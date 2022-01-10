<?php
$PHP = '../'
?><?php
$VER = time();
$PHP = (isset($PHP) ? $PHP : '') . './__php';
$ATTACH = './src/__attach';
$ASSETS = './src/__assets';
$ROOT = './src/Root';
$MODE = 'dev';

require_once $PHP . '/__load.php';
?><?php
$db = new JustField\DB($orm);

function gen_from_get($prefix) { 
   return function (&$variable, $get_key, $is_echo = true) use ($prefix) { 
      if (isset($_GET[$get_key])) { 
         $variable = $_GET[$get_key]; 
      } else if ($is_echo) { 
         echo($prefix . ': ' . "no \"$get_key\" in \$_GET" . '<br>'); 
      } else { 
         $variable = null; 
      } 
   }; 
} 

function gen_from_post($prefix) { 
   return function (&$variable, $get_key, $is_echo = true) use ($prefix) { 
      if (isset($_POST[$get_key])) { 
         $variable = $_POST[$get_key]; 
      } else if ($is_echo) { 
         echo($prefix . ': ' . "no \"$get_key\" in \$_POST" . '<br>'); 
      } else { 
         $variable = null; 
      } 
   }; 
} 
?><?php
if (isset($_GET['script']) || isset($_POST['script'])):
   $script = isset($_GET['script']) ? $_GET['script'] : $_POST['script'];

   if ($script == 'exit'):
      session_start();
      unset($_SESSION['id']);
      session_destroy();

      header("Location: ./../login");
      die;


   elseif ($script == 'login'):
      if (isset($_POST['login']) && isset($_POST['password'])):
         session_start();

         $login = $_POST['login'];
         $password = $_POST['password'];

         $db->orm->is_log = false;
         $id = $db->orm->from('account')->select('id_account')->where("account_login = '$login' AND account_password = '$password'")();

         if (!$id):
            $_SESSION['login_error'] = 'uncorrect login or password';
            header('Location: ./../login/');
         
         else:
            $id = $id[0]['id_account'];
            $_SESSION['id'] = $id;

            unset($_SESSION['login_error']);
            header('Location: ./../dashboard/');
         
         endif;

      else:
         echo('NO POST');

      endif;
   
   else: // other scripts can give DB data, so need check for login OK - die-if-bad
?><?php
session_start();

if (!isset($_SESSION['id'])) {
   session_destroy();
   exit("<meta http-equiv='refresh' content='0; url=./../login'>");
   die;
}?><?php
      if ($script == 'field-add'):
         $from_get = gen_from_get('field-add');

         $from_get($field_type_id, 'type-id');
         $from_get($path, 'path');
         
         $db->orm->is_log = false;
         $new_field_id = $db->at_path($path)->add_field($field_type_id);

         echo '{ "status": "OK", "id": "'.$new_field_id.'"}';


      elseif ($script == 'field-update'):
         $from_post = gen_from_post('field-update');

         $from_post($item_id, 'item_id');
         $from_post($colname, 'colname');
         $from_post($value, 'value', false);

         $db->orm->is_log = false;
         $res = $db->at_id($item_id)->update($colname, $value);

         echo json_encode([
            'status' => 'OK',
            'data' => $res,
         ]);


      elseif ($script == 'field-delete'):
         $from_get = gen_from_get('field-delete');

         $from_get($item_id, 'item_id');

         $db->orm->is_log = false;
         $db->at_id($item_id)->remove();

         echo '{ "status": "OK" }';


      elseif ($script == 'field-duplicate'):
         $from_get = gen_from_get('field-duplicate');
      
         $from_get($item_id, 'item_id');

         $db->orm->is_log = false;
         $ret = $db->at_id($item_id)->duplicate();

         $new_id = $ret->new_field_id;
         $data = $ret->duplicate_res;

         echo '{ "status": "OK", "id": '.$new_id.', "data": "'.$data.'" }';
         

      elseif ($script == 'field-move'):
         $from_post = gen_from_post('field-move');

         $from_post($item_id, 'item_id');
         $from_post($target_parent_id, 'target_parent_id');

         ob_start();
         $field = $db->move_field($item_id, $target_parent_id);
         $res = ob_get_clean();

         $ech = [
            'status' => 'OK',
            'id' => $field->id,
            'key' => $field->key,
            'name' => $field->name,
            'value_html' => $res,
            'type' => $field->type->name,
         ];

         echo json_encode($ech);
         

      elseif ($script == 'field-render'):
         $from_post = gen_from_post('field-render');

         $from_post($item_id, 'item_id');

         $field = $db->at_id($item_id);

         ob_start();
         JustField\DBItem::render($field->type->name, $field);
         $res = ob_get_clean();

         $ech = [
            'status' => 'OK',
            'html' => $res,
         ];

         echo json_encode($ech);
         

      elseif ($script == 'field-value-render'):
         $from_post = gen_from_post('field-value-render');

         $from_post($item_id, 'item_id');

         $field = $db->at_id($item_id);
         $behaviour = $field->get_type_behaviour();

         ob_start();
         $behaviour::render_value($field);
         $res = ob_get_clean();

         $ech = [
            'status' => 'OK',
            'html' => $res,
         ];

         echo json_encode($ech);


      elseif ($script == 'info'):
         phpinfo();
         

      else:
         echo '{ "status": "ERR", "message": "Error: unexpected script" }';


      endif;
      

   endif;


else:
   echo '{ "status": "ERR", "message": "Error: no or unexpected script" }';

endif;?>