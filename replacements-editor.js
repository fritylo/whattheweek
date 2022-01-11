$(document).ready(() => {
   $('.button_add-rule').click(e => {
      let $button = $(e.currentTarget);
      let $input = $button.parent().prev();

      $newInput = $input.clone().find('input').val('').parent().insertBefore($button.parent());
      
      rowHandle($newInput[0]);
   });
   
   $('.rowf1').each((i, row) => rowHandle(row));
   
   function rowHandle(row) {
      row.querySelector('button').addEventListener('click', e => {
         e.currentTarget.parentElement.remove();
      });
   }
   
   $('form').submit(e => {
      let $form = $(e.currentTarget);

      let json = {};
      $('.rowf1').each((i, row) => {
         let $row = $(row);
         let from = $row.find('input[role="from"]').val(),
            to = $row.find('input[role="to"]').val();        
         if (from)
            json[from] = to;
      });
      console.log(json);

      $form.find('[name="json"]').val(JSON.stringify(json));
   });
});