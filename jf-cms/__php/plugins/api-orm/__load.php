<?php
$orm_mysqli = null;

function orm_mysqli_init($host, $user, $pass, $db_name) {
   global $orm_mysqli;
   $orm_mysqli =  new mysqli($host, $user, $pass, $db_name);

   if ($orm_mysqli->connect_error) {
      die('ORM mysqli connection error (' . $orm_mysqli->connect_errno . ') '
         . $orm_mysqli->connect_error);
   }
}
class ORM {
   var $db;

   var $is_log = false;
   var $is_simulate = false;
   var $last_operation = null;
   var $last_operation_args = null;

   var $table_prefix = '';
   var $conditions;
   var $selector;
   var $table_name;
   var $table_name_raw;

   function __construct($host = null, $user = null, $pass = null, $db_name = null)
   {
      global $orm_mysqli;

      if ($host !== null) {
         orm_mysqli_init($host, $user, $pass, $db_name);
      }

      $this->db = $orm_mysqli;
      $this->conditions = '';
   }

   // CONFIG
   function __clone() {
      $new_orm = new ORM();

      $new_orm->is_log = $this->is_log;

      $new_orm->table_prefix = $this->table_prefix;
      $new_orm->conditions = $this->conditions;
      $new_orm->selector = $this->selector;
      $new_orm->table_name = $this->table_name;
      $new_orm->table_name_raw = $this->table_name_raw;
      $new_orm->is_simulate = $this->is_simulate;

      return $new_orm;
   }

   function from($table) {
      $this->conditions = '';
      $this->table_name_raw = $table;
      $this->table_name = $this->table_prefix . $table;
      return $this;
   }
   function table($table)
   {
      return $this->from($table);
   }

   function where($conditions) {
      $this->conditions = $conditions;
      return $this;
   }
   function where_id($id)
   {
      $this->conditions = "`id_{$this->table_name_raw}` = '$id'";
      return $this;
   }

   function close() {
      $this->db->close();
   }


   function is_need_log($sql, $log_callback) {
      $sql = str_replace("\n", ' ', $sql);

      if ($this->is_log)
         if (is_array($this->is_log)) {
            foreach ($this->is_log as $query_regex) {
               if (preg_match($query_regex, $sql)) {
                  $log_callback();
               }
            }
         }
         else
            $log_callback();
   }


   // QUERY TO DB
   function __invoke($fetch_type = MYSQLI_ASSOC)
   {
      $where_str = $this->gen_conditions_string();
      $sql = '';
      $assoc = $this->last_operation_args;

      switch ($this->last_operation) {
         case 'select':
            $sql = "SELECT\n  {$this->selector}\nFROM\n  `{$this->table_name}`\nWHERE\n  {$where_str};";
            break;

         case 'update':
            $query_str = '';

            foreach ($assoc as $key => $val) {
               $val = $this->get_val($val);
               $query_str .= "`$key` = $val,\n  ";
            }
            $query_str = mb_substr($query_str, 0, mb_strlen($query_str) - 4);

            $sql = "UPDATE\n  `{$this->table_name}`\nSET\n  {$query_str}\nWHERE\n  {$where_str};";
            break;

         case 'insert':
            $keys = array_keys($assoc);
            $vals = array_values($assoc);

            $keys_str = '`' . implode("`,\n  `", $keys) . '`';
            $vals_str = '';
            foreach ($vals as $val) {
               $val = $this->get_val($val);
               $vals_str .= "$val,\n  ";
            }
            $vals_str = mb_substr($vals_str, 0, mb_strlen($vals_str) - 4);

            $sql = "INSERT INTO  `{$this->table_name}` (\n  {$keys_str}\n) VALUES (\n  {$vals_str}\n);";
            break;

         case 'delete':
            $sql = "DELETE FROM\n  `{$this->table_name}`\nWHERE\n  {$where_str};";
            break;

         default;
      };

      if (!$this->is_simulate)
         return $this->query($sql, $fetch_type);
      else
         $this->console_log($sql);
      return $sql;
   }

   function take($fetch_type = MYSQLI_ASSOC) {
      return $this->__invoke($fetch_type);
   }


   // Operations
   function select($selector)
   {
      $this->last_operation = 'select';
      $this->selector = $selector;
      return $this;
   }
   function update($assoc)
   {
      $this->last_operation = 'update';
      $this->last_operation_args = $assoc;
      return $this;
   }
   function insert($assoc)
   {
      $this->last_operation = 'insert';
      $this->last_operation_args = $assoc;
      return $this;
   }
   function delete()
   {
      $this->last_operation = 'delete';
      return $this;
   }


   // Private
   private function query($sql, $fetch_type = null)
   {

      $this->conditions = '';
      $this->last_operation = '';
      $this->last_operation_args = [];

      $res = $this->db->query($sql);

      if ($fetch_type && !is_bool($res)) {
         $ret = $res->fetch_all($fetch_type);

         $this->is_need_log($sql, function () use ($sql, $ret) {
            $first_word = strtok($sql, "\n");
            $first_word = strtok($first_word, " ");

            $line = str_repeat('-', strlen("ORM : $first_word"));

            $this->console_log("$line\nORM : $first_word\nSQL\n{$sql}\nRES\n" . print_r($ret, true));
         });
         
         return $ret;
      }
      else {
         $ret = $res;

         $this->is_need_log($sql, function () use ($sql, $ret) {
            $first_word = strtok($sql, "\n");
            $first_word = strtok($first_word, " ");

            $line = str_repeat('-', strlen("ORM : $first_word"));

            $this->console_log("$line\nORM : $first_word\nSQL\n{$sql}\nRES\n" . (is_bool($ret) && $ret ? 'true' : 'false'));
         });

         return $ret;
      }
   }

   private function gen_conditions_string()
   {
      return $this->conditions ? $this->conditions : '1';
   }

   private function console_log($message)
   {
      if ($this->is_log) {
         $message = str_replace('`', '\`', $message);
         echo "<script>console.log(`$message`);</script>";
      }
   }

   private function get_val($val) {
      if (is_string($val)) {
         $val = $this->db->escape_string($val);
         return "'$val'";
      } else {
         if ($val === null) return 'NULL';
         return $val;
      }
   }

   // static
   static function string_starts_with($string, $startString) {
      $len = strlen($startString);
      return (substr($string, 0, $len) === $startString);
   }
}

require_once __DIR__ . '/../../db-connect-info.php';
$orm = new ORM(
   'localhost', 
   jf_DB_LOGIN, 
   jf_DB_PASSWORD, 
   jf_DB_DBNAME
);
$orm->table_prefix = jf_DB_TABLE_PREFIX;
$orm->is_log = jf_DB_IS_LOG;