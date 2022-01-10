$(document).ready(function () {
   alert('Будьте внимательны!!!\n\nПеред вами стоит не простая задача - совладать с этим гигантским файлом. На кону пропуски пар вашими сокурсниками, либо нет.\nСледите за состоянием панели управления и подсказки рядом с вашим курсором.\n\nВНИМАНИЕ: День недели меняется автоматически, если вы заполнили ШЕСТУЮ (6) ПАРУ. \nПредположим расписание дня заканчивается на 4 паре. Тогда сменить день недели надо менять вручную.\n\nМожно закрепить стобик при прокрутке, для этого нажмите на заголовок стобика в таблице.');
   
   $('thead td').click(e => {
      $td = $(e.currentTarget);
      const childN = Array.from($td.parent()[0].children).findIndex(el => el == $td[0]) + 1;

      let leftPos = 30;
      $('thead .table-sticky').each((i, el) => {
         leftPos += el.getBoundingClientRect().width;
      });

      $(`tbody td:nth-child(${childN})`).add($td).toggleClass('table-sticky').css('left', leftPos + 'px');
   });

   const schedule = {};
   for (let week of $('.select-order__week')) {
      week = week.dataset.value;
      schedule[week] = {};
      for (let day of $('.select-order__day')) {
         day = day.dataset.value;
         schedule[week][day] = {};
         for (let lesson of [1,2,3,4,5,6]) {
            schedule[week][day][lesson] = {};
            for (let prop of $('.select-order__prop')) {
               prop.textContent = prop.dataset.start;
               prop = prop.dataset.value;
               schedule[week][day][lesson][prop] = '';
            }
         }
      }
   }
   window.schedule = schedule;
   
   $('tbody td').click(e => {
      const valuePath = $('.selected').toArray().map(el => el.dataset.value);

      const $selectedProp = $('.selected').last();
      let cellText = e.currentTarget.textContent.trim();
      if (cellText.length > 15)
         cellText = cellText.slice(0, 16) + '...';
      $selectedProp.text(cellText);
      
      let target = schedule;
      for (let i = 0; i < valuePath.length - 1; i++)
         target = target[valuePath[i]];

      let lastPathPart = valuePath.pop();

      if (lastPathPart == 'number') {
         window.currentNumber = e.currentTarget.textContent.trim();
      }
      else { // lastPathPart != 'number'
         if (!window.currentNumber) {
            alert('Сперва выберите номер пары, затем всё остальное.');
            $('.select-order__prop.selected').removeClass('selected').parent().find('*:first-child').addClass('selected');
            return;
         }
         else { // is currentNumber
            target[window.currentNumber][lastPathPart] = e.currentTarget.textContent.trim();
         }
      }
      
      console.log(schedule);
      selectNextProp();
   });
   
   function selectNextProp() {
      let [$week, $day, $prop] = $('.selected').toArray();
      [$week, $day, $prop] = [$($week), $($day), $($prop)];
      
      let isLastLesson = window.currentNumber == 6;
      
      if ($prop.is('*:last-child')) {
         $prop.removeClass('selected').parent().find('*:first-child').addClass('selected');
         $('.select-order__prop').each((i, el) => (el.textContent = el.dataset.start));
         window.currentNumber = null;
         if (isLastLesson) {
            if ($day.is('*:last-child')) {
               $day.removeClass('selected').parent().find('*:first-child').addClass('selected');
               if ($week.is('*:last-child')) {
                  $week.removeClass('selected').parent().find('*:first-child').addClass('selected');
               } else {
                  $week.removeClass('selected').next().addClass('selected');
               }
            } else {
               $day.removeClass('selected').next().addClass('selected');
            }
         }
      } else {
         $prop.removeClass('selected').next().addClass('selected');
      }

      $hint.updateText();
   }

   $('[role="moveup"]').click(e => {
      $('.select-order').css({
         bottom: 'auto',
         top: '1em',
      });
   });
   $('[role="movedown"]').click(e => {
      $('.select-order').css({
         bottom: '1em',
         top: 'auto',
      });
   });
   
   $('.row > *').click(e => {
      const $button = $(e.currentTarget);
      const $section = $button.parent();
      $section.find('.selected').removeClass('selected');
      $button.addClass('selected');
      
      if ($button.hasClass('select-order__lesson')) {
         $('.select-order__prop.selected').removeClass('selected').parent().find('*:first-child').addClass('selected');
         window.currentNumber = null;
      }
      if ($button.hasClass('select-order__day')) {
         $('.select-order__lesson.selected').removeClass('selected').parent().find('*:first-child').addClass('selected');
         $('.select-order__prop.selected').removeClass('selected').parent().find('*:first-child').addClass('selected');
         window.currentNumber = null;
      }
      if ($button.hasClass('select-order__week')) {
         $('.select-order__day.selected').removeClass('selected').parent().find('*:first-child').addClass('selected');
         $('.select-order__lesson.selected').removeClass('selected').parent().find('*:first-child').addClass('selected');
         $('.select-order__prop.selected').removeClass('selected').parent().find('*:first-child').addClass('selected');
         window.currentNumber = null;
      }

      $hint.updateText();
   });
   
   const $hint = $('.select-order__hint');
   const hintPadding = {x:30, y:-20};
   const hintPos = {x:0, y:0};
   $(window).on('mousemove', e => {
      hintPos.x = e.clientX;
      hintPos.y = e.clientY;
   });
   setInterval(() => $hint.css({ top: hintPos.y + hintPadding.y + 'px', left: hintPos.x + hintPadding.x + 'px' }), 50);
   $hint.updateText = () => {
      $hint.text($('.selected').toArray().map(el => el.textContent).join(' > '));
   };
   $hint.updateText();
   
   $('[role="finish"]').click(e => {
      $storage = $('[role="finish-storage"]')
      $storage.val(JSON.stringify(schedule));
      $storage.parent()[0].submit();
   });
});