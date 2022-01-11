async function main() {
   setTimeout(() => {
      window.scrollTo({
         top: 0,
         behavior: 'auto',
         left: 0,
      });
   }, 1000);

   try {
      window.replacements = await fetch(
         'storage/' + $('.button_repl-editor').attr('data-file')
      ).then(res => res.json());
   } catch (err) {
      console.log('No replacements');
   }

   updateButton.addEventListener('click', async e => {
      const lastLink = sel('.last-link');
      $('input[name="group"]').val(lastLink.textContent);
      $('input[type="file"]', updateButton).trigger('click');
   });
   $('input[type="file"]', updateButton).on('change', async e => {
      e.currentTarget.parentElement.submit();
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

         const prevCurrent = (document.querySelector('.weekday_current'));
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
         
         lastLink = links.findIndex(el => el == e.target);
         lastLink = lastLink > 4 ? lastLink - 5 : lastLink;
         localStorage.setItem('lastLink', lastLink);
         lastLinkElement.classList.add('last-link');
         
         updateButton.querySelector('strong').textContent = e.target.textContent;

         loadToday(e.target.href, weekType);
      });
   });

   let localLastLink = localStorage.getItem('lastLink');
   if (localLastLink) {
      let link = links[+localLastLink + (weekType == 'red' ? 5 : 0)];
      link.classList.add('last-link');
      loadToday(link.href, weekType);
      lastLinkElement = link;
      updateButton.querySelector('strong').textContent = link.textContent;
   }

   async function loadToday() {
      if (intervalUpdate) clearInterval(intervalUpdate);

      const groupName = $('.last-link').text();

      todayBlock.innerHTML = '<div class="today-schedule__message">Идет загрузка</div>';
      let dots = 1;
      let intervalLoad = setInterval(() => {
         todayBlock.querySelector('.today-schedule__message').innerHTML = 'Идет загрузка' + '.'.repeat(dots);
         ++dots > 3 ? (dots = 1) : '';
      }, 1000);

      let res = null;
      let fetchErr = false;
      try {
         res = await fetch(`./storage/${groupName}.json`)
      } catch (err) {
         alert('При попытке получения данных с сервера возникла ошибка.\nВозможно расписание ещё не было загружено.\nПопробуйте загрузить расписание.\nЕсли это не помогает - свяжитесь с разработчиком (контакты внизу страницы).');
         todayBlock.querySelector('.today-schedule__message').innerHTML = 'Произошла ошибка на сервере...';
         clearInterval(intervalLoad);
         return;
      }

      if (res.status != 200) {
         alert('При попытке получения данных с сервера возникла ошибка.\nВозможно расписание ещё не было загружено.\nПопробуйте загрузить расписание.\nЕсли это не помогает - свяжитесь с разработчиком (контакты внизу страницы).');
         todayBlock.querySelector('.today-schedule__message').innerHTML = 'Произошла ошибка на сервере...';
         clearInterval(intervalLoad);
         return;
      };

      let schedule = null;
      try {
         schedule = await res.json();
      } catch (err) {
         alert('При попытке получения данных с сервера возникла ошибка.\nВозможно расписание ещё не было загружено.\nПопробуйте загрузить расписание.\nЕсли это не помогает - свяжитесь с разработчиком (контакты внизу страницы).');
         todayBlock.querySelector('.today-schedule__message').innerHTML = 'Произошла ошибка на сервере...';
         clearInterval(intervalLoad);
         return;
      }
      window.schedule = schedule;

      const lastUpdateTime = schedule.time * 1000;
      schedule = schedule[weekType == 'red' ? 'even' : 'odd'][$('.weekday_current').text()];
      console.log(schedule);

      clearInterval(intervalLoad);
      
      const timetable = [
         '',
         '8:00-9:30',
         '9:50-11:20',
         '11:30-13:00',
         '13:20-14:50',
         '15:00-16:30',
         '16:40-18:10',
      ];
      const breaks = [
         '',
         '10 мин.',
         '10 мин.',
         '20 мин.',
         '10 мин.',
         '10 мин.',
      ];
      
      let tableHtml = '<table>';
      for (let lessonNumber in schedule) {
         const lesson = schedule[lessonNumber];
         let classroom = lesson.classroom;
         if (classroom.match(/moodle\.cfuv/)) {
            classroom = `<a href="${classroom}" target="_blank">moodle</a>`;
         }
         tableHtml += `
            <tr>
               <td>${lessonNumber}</td>
               <td>${timetable[lessonNumber]}</td>
               <td>${breaks[lessonNumber]}</td>
               <td style="width: 100%">${lesson.name}</td>
               <td>${lesson.teacher}</td>
               <td>${classroom}</td>
               <td>${lesson.type}</td>
            </tr>
         `;
      }
      tableHtml += '</table>';
      tableHtml += '<div class="last_update">'+ (new Date(lastUpdateTime).toLocaleString()) +'</div>';

      table = new DOMParser().parseFromString(tableHtml, 'text/html');
      const lastUpdateEl = table.querySelector('.last_update');
      const lastUpdate = lastUpdateEl.textContent.replace('Последнее обновление было: ', 'Версия расписания: ');
      lastUpdateEl.remove();

      let
         len = () => Math.max(...Array.from(table.querySelectorAll('tr')).map(tr => tr.children.length)),
         each = (callback) => table.querySelectorAll('td').forEach(callback),
         // i - tr index, n - total td count in row
         indexed = (i, n, callback) => each((td, ii, arr) => ii % n == i ? callback(td, ii, arr) : ''),
         // t - tr index "target"
         two = (i, t, n, callback) => indexed(i, n, (td, ii, arr) => callback(arr[ii], arr[ii + (t - i)], arr)),
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
         for (let target in replacements) {
            let repl = replacements[target];
            td.innerHTML = td.innerHTML.replace(new RegExp(target, 'i'), repl);
         }
      });
      indexed(4, len(), td => {
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
