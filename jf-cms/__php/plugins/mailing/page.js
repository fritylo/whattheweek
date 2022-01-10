;(function () {
   const pref = '.mailing';
   const sendLink = '../__php/plugins/mailing/sendmail.php';

   document.querySelectorAll(`${pref}_button_send`).forEach(el => el.addEventListener('click', action('click: send button')));
   when('click: send button', async e => {
      const data = e.currentTarget.dataset;
      
      let domain = window.location.hostname;

      let res; 
      try {
         res = await fetchJsonOk('Sending', sendLink, {
            method: 'POST',
            body: {
               from: data.sender,
               to: data.receivers,
               subject: data.subject,
               message: data.message,
               domain: domain,
            },
         });
      } catch (err) {
         alert('Error while sending mails:\n\n' + err.res.message);
         return;
      }

      console.log(res);
      
      if (res.status == 'OK') {
         alert(`"${data.subject}" have been sent successfully`);
      }
   });
})();