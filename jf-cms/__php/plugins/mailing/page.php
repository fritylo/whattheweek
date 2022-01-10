<?php function mailing_page() { ?>
   <?php global $db, $reg; ?>

   <?php $newsletters = $db->at_path('mailing')->get_children(); ?>
   <?php $is_data = $newsletters ? count($newsletters) > 1 : false; // 1 for template element ?>

   <?php if ($is_data) : ?>

      <table data-action-link="">
         <thead>
            <tr>
               <td class="tac">ID</td>
               <td>Sender</td>
               <td>Name</td>
               <td class="w100">Subject</td>
               <td>Inspect</td>
               <td class="tac">Send button</td>
            </tr>
         </thead>
         <tbody>

            <?php foreach ($newsletters as $mail) : ?>

               <?php if ($mail->key == '__tpl__') continue; ?>

               <?php $id = $mail->id; ?>
               <?php $name = $mail->name; ?>

               <?php $sender = $mail->at_path('sender')->value; ?>
               <?php $subject = $mail->at_path('subject')->value; ?>
               <?php $message = $mail->at_path('message')->value->html; ?>

               <?php $selectors = $mail->at_path('selectors'); ?>
               <?php $receivers = $reg->mailing->selectors_to_emails($selectors); ?>

               <tr>
                  <td colname="id" class="tac"><?= $id ?></td>
                  <td colname="sender"><?= $sender ?></td>
                  <td colname="name"><?= $name ?></td>
                  <td colname="subject" class="w100"><?= $subject ?></td>
                  <td colname="inspect"><a style="color: var(--c2)" href="../field/?p=mailing/<?= $mail->key ?>&pi=2&view=tree">Open</a></td>
                  <td colname="send" class="p0">
                     <button class="box p1 box_mode_dark button tac cup brad0 w100 mailing_button_send"
                        data-sender="<?= htmlspecialchars($sender) ?>"
                        data-receivers="<?= htmlspecialchars($receivers) ?>"
                        data-subject="<?= htmlspecialchars($subject) ?>"
                        data-message="<?= htmlspecialchars($message) ?>"
                     >
                        Send
                     </button>
                  </td>
               </tr>

            <?php endforeach; ?>

         </tbody>
      </table>

   <?php else : ?>

      <h2 class="tac">No newsletters.</h2>
      <p class="plr1">
         How to add newsletter:
      </p>
      <ol class="pr1">
         <li>Duplicate field with name <strong><code>__tpl__</code></strong> at <code><a href="../field/?view=tree&p=mailing&pi=1" style="color: var(--c2);"><strong>/mailing</strong></a></code> path.</li>
         <li>Change key, and name to something with sense. <span style="color: red">(!important)</span></li>
         <li>Change newsletter content: subject, message, and selectors.</li>
      </ol>

   <?php endif; ?>

<?php } ?>