async function main() {
    setTimeout(() => {
       window.scrollTo({
          top: 0,
          behavior: 'auto',
          left: 0,
       });
    }, 500);

    window.replacements = await fetch('./replacements.json').then(res => res.json());

    updateButton.addEventListener('click', async e => {
        const lastLink = sel('.last-link');
        const startWeekType = weekType;

        const freeupRes = JSON.parse(await fetchScript('./freeup-cache.php', lastLink.href, lastLink.textContent));
        if (freeupRes.message == 'BAD') {
            console.log('On update, on storage freeup - error, with $_POST:', freeupRes.post);
            return;
        }

        for (const link of document.querySelectorAll('.red-list a.special')) {
            console.log(`Caching (red): ${link.textContent}`);
            weekType = 'red';
            await fetchScript('./cache-all.php', link.href, link.textContent);
        }
        for (const link of document.querySelectorAll('.green-list a.special')) {
            console.log(`Caching (green): ${link.textContent}`);
            weekType = 'green';
            await fetchScript('./cache-all.php', link.href, link.textContent);
        }
        weekType = startWeekType;
        await fetchScript('./cache-all.php', lastLink.href, lastLink.textContent);

        // FIXME: LOADING JUST GREEN WEEK OF PI-201(2)

        updateButton.textContent = 'Готово!!! КИМ, падай на здоровье ;)';
        updateButton.disabled = true;
    });

    colorSwitch.addEventListener('click', e => {
        const main = document.querySelector('main');
        main.classList.remove(weekType == 'red' ? 'red' : 'green');
        main.classList.add(weekType == 'red' ? 'green' : 'red');

        weekType = weekType == 'red' ? 'green' : 'red';
        lastLinkElement.classList.remove('last-link');
        lastLinkElement = Array.from(document.querySelectorAll(`.${weekType}-list .special`)).find(button => button.textContent == lastLinkElement.textContent);
        lastLinkElement.classList.add('last-link');

        loadToday(lastLinkElement.href);
    });

    function getWeekNumber(d) {
       // Copy date so don't modify original
       d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
       // Set to nearest Thursday: current date + 4 - current day number
       // Make Sunday's day number 7
       d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
       // Get first day of year
       var yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));
       // Calculate full weeks to nearest Thursday
       var weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
       // Return array of year and week number
       // return [d.getUTCFullYear(), weekNo];
       return weekNo;
    }

    let sel = document.querySelector.bind(document),
       week = sel('.week'),
       main = sel('main'),
       todayBlock = sel('.today-schedule'),
       weekDays = Array.from(document.querySelectorAll('.weekdays > div:not(.color-switch)')),
       weekNumber = getWeekNumber(new Date()),
       weekType = weekNumber % 2 != 0 ? 'green' : 'red',
       weekDay = new Date().getDay(),
       intervalUpdate, 
       kimOpenButton = sel('.kim-open'),
       lastLinkElement,
       holydays = weekDay == 6 || weekDay == 0;

    if (holydays) weekType = weekType == 'red' ? 'green' : 'red';

    function weekDayButton(number) {
       return weekDays.find(day => day.dataset.number == number);
    }
    const weekDayButtonToday = weekDayButton(weekDay);
    if (weekDayButtonToday)
       weekDayButtonToday.classList.add('weekday_today', 'weekday_current');
    else
       weekDayButton(1).classList.add('weekday_current');

    weekDays.forEach(dayButton => {
       dayButton.addEventListener('click', e => {
          weekDay = +e.target.dataset.number;
          loadToday(lastLinkElement.href, lastLinkElement.textContent);

          const prevCurrent = (document.querySelector('.weekday_current'))
          if (prevCurrent) prevCurrent.classList.remove('weekday_current');
          e.target.classList.add('weekday_current');
       });
    });

    main.classList.add(weekType);

    let date = new Date(),
       timeString = date.toLocaleDateString('ru') + ', ' + date.toLocaleString('ru', { weekday: 'long' });

    if (!holydays)
       week.innerHTML = `
                На момент ${timeString} (сегодня), <strong>${weekType == 'red' ? 'Красная (четная)' : 'Зеленая (нечетная)'}</strong> неделя.
             `;
    else
       week.innerHTML = `
                Сейчас выходные - ${timeString} (сегодня). Следующая неделя <strong>${weekType == 'red' ? 'Красная (четная)' : 'Зеленая (нечетная)'}</strong>.
             `;

    let links = Array.from(document.querySelectorAll('a.special'));
    links.forEach(a => {
       a.addEventListener('click', e => {
          e.preventDefault();
          if (lastLinkElement)
             lastLinkElement.classList.remove('last-link');
          lastLinkElement = e.target;
          loadToday(e.target.href, weekType);
          lastLink = links.findIndex(el => el == e.target);
          lastLink = lastLink > 4 ? lastLink - 5 : lastLink;
          localStorage.setItem('lastLink', lastLink);
          lastLinkElement.classList.add('last-link');
       });
    });

    let localLastLink = localStorage.getItem('lastLink');
    if (localLastLink) {
       let link = links[+localLastLink + (weekType == 'red' ? 5 : 0)];
       link.classList.add('last-link');
       loadToday(link.href, weekType);
       lastLinkElement = link;
    }

    async function loadToday(link, group, script = './load.php') {
       if (intervalUpdate) clearInterval(intervalUpdate);
       kimOpenButton.parentElement.href = link;

       todayBlock.innerHTML = '<div class="today-schedule__message">Идет загрузка</div>';
       let dots = 1;
       let intervalLoad = setInterval(() => {
          todayBlock.querySelector('.today-schedule__message').innerHTML = 'Идет загрузка' + '.'.repeat(dots);
          ++dots > 3 ? (dots = 1) : '';
       }, 1000);
       
       let linkData = new URLSearchParams(link.slice(link.split('').indexOf('?'))),
          groupName = linkData.get('Selected_Group');

       console.log(link);
       
    /*
       // FIXME: disabled functionality of load.php
       todayBlock.querySelector('.today-schedule__message').innerHTML = '<div>Загрузка расписания отключена из-за высокой нагрузки на сервер.<br><br><strong>Кнопка внизу страницы - переход на сайт КИМ</strong></div>';
       clearInterval(intervalLoad);
       return;
    */

       let table = await fetchScript('./load.php', link, groupName);
       console.log('Given html: ', table);

       if (!table || table == '<table></table>') {
          clearInterval(intervalLoad);
          todayBlock.querySelector('.today-schedule__message').innerHTML = 'Произошла ошибка на сервере...';
          return;
       }

       table = new DOMParser().parseFromString(table, 'text/html');
       const lastUpdateEl = table.querySelector('.last_update');
       const lastUpdate = lastUpdateEl.textContent.replace('Последнее обновление было: ', 'Версия расписания: ');
       lastUpdateEl.remove();

       let 
          len = () => Math.max(...Array.from(table.querySelectorAll('tr')).map(tr => tr.children.length)),
          each = (callback) => table.querySelectorAll('td').forEach(callback),
          // i - tr index, n - total td count in row
          indexed = (i, n, callback) => each((td, ii, arr) => ii % n == i ? callback(td, ii, arr) : ''),
          // t - tr index "target"
          two = (i, t, n, callback) => indexed(i, n, (td, ii, arr) => callback(arr[ii], arr[ii+(t-i)], arr)),   
          remove = (i, n) => indexed(i, n, td => td.remove()),
          small = (i, n) => indexed(i, n, td => td.classList.add('small')),
          onclick = (i, n, callback) => indexed(i, n, td => td.addEventListener('click', callback)),
          becometip = (i, t, n) => two(i, t, n, (tdi, tdt) => {
             let html = tdi.innerHTML;
             if (html) {
                tdt.setAttribute('data-tip', html);
                tdt.classList.add('tippied');
                tdt.classList.add('cup');
             }
          }),
          swap = (i, t, n) => two(i, t, n, (eli, elt) => {
             let parent = elt.parentElement;
             parent.insertBefore(elt.cloneNode(true), eli);
             parent.insertBefore(eli.cloneNode(true), elt);
             eli.remove();
             elt.remove();
          });

       remove(2, len());
       remove(5, len());
       small(3, len());
       small(4, len());
       small(1, len());
       swap(0, 1, len());
       becometip(3, 2, len());
       remove(3, len());
       indexed(0, len(), td => (td.innerHTML = td.innerHTML.replace('-', '<br>')));
       indexed(2, len(), td => {
          shrinkName(td);
          const lessonType = cutoutLessonType(td);
       });
       indexed(3, len(), td => {
          const replacements = {
             'ссылка на moodle\\.cfuv\\.ru': 'moodle',
             'СПОРТ ЗАЛ ТA': 'Спортзал',
          };
          for (let target in replacements) {
             let repl = replacements[target];
             td.innerHTML = td.innerHTML.replace(new RegExp(target, 'i'), repl);
          }
       });

       setTimeout(initTips, 50);

       todayBlock.innerHTML = `
          <div class="table-wrapper">
             ${table.documentElement.innerHTML}
             <div class="last-update">${lastUpdate}</div>
          </div>
       `;

       clearInterval(intervalLoad);

       kimOpenButton.classList.remove('kim-open_alife');
       document.body.getBoundingClientRect();
       kimOpenButton.classList.add('kim-open_alife');

       setInterval(() => loadToday(link), 2 * 60 * 60 * 1000); // every 2 hours
    }

    function fetchScript(script, link, groupName) {
        return fetch(script, {
          method: 'POST',
          body: Object.entries({
             'schedule_link': encodeURIComponent(link),
             'weekday_number': weekDay > 0 && weekDay < 6 ? (weekDay - 1) : (0),
             'group': groupName,
             'week_type': weekType,
          }).map(([key, val])=>`${key}=${val}`).join('&'),
          headers: {'Content-type': 'application/x-www-form-urlencoded'},
       }).then(res => res.text());
    }

    function initTips() {
       tippy('.tippied', { content: el => el.dataset.tip });
       // tippy('table', { content: 'Расписание на сегодня' });
    }

    function shrinkName(td) {
       let html = td.innerHTML;
       let match = html.match(/(?<name>.*?)(?=(\s*\(|$))/);

       if (!match) return;

       let subjectName = match.groups.name;
       console.log('subject name:', subjectName);
       
       if (replacements[subjectName])
          td.innerHTML = html.replace(new RegExp(subjectName + '\\s*'), replacements[subjectName] + ' ');

       //if (td.innerHTML == 'undefined ')
       //   td.innerHTML = '';
    }

    function cutoutLessonType(td) {
       let lessonType,
          html = td.innerHTML;
       
       
       if (html) {
          let match = html.match(/\((.*)\)/);
          if (match) {
             lessonType = match[1];
          } else {
             lessonType = 'З';
          }
       } else {
          lessonType = '';
       }

       td.innerHTML = html.replace(` (${lessonType})`, '');
       return lessonType;
    }
}

main();
