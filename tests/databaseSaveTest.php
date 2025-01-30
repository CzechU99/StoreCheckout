<?php

  use PHPUnit\Framework\TestCase;

  require_once('./includes/database.php');
  require_once('./includes/db_object.php');
  require_once('./includes/user.php');

  class DatabaseSaveTest extends TestCase{

    public function testUserCanBeSaved(){

      $mockDatabase = $this->createMock(Database::class);

      $mockDatabase->method('query')->willReturn(true);
      $mockDatabase->method('the_insert_id')->willReturn(1);

      $user = new User();
      $user->email = "test@example.com";
      $user->password = "securepassword";
      $user->name = "Jan";
      $user->surname = "Kowalski";
      $user->phone = "2323423423";
      $user->address = "Opole";
      $user->city = "Opole";
      $user->postal_code = "43-234";
      $user->newsletter = 1;
      $user->created_at = date('Y-m-d H:i:s');

      global $database;
      $database = $mockDatabase;

      $this->assertTrue($user->save());

    }

  }