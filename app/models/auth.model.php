<?php

class Auth extends Database
{
  public static function checkUsername($username)
  {
    try {
      $stmt = self::connect()->prepare("SELECT username FROM account WHERE username = :username");
      $stmt->bindParam(':username', $username);
      $stmt->execute();

      return (bool) $stmt->fetch();

    } catch (PDOException $e) {
      self::error("db_error", $e->getCode(), $e->getMessage());
    }
  }

  public static function checkEmail($email)
  {
    try {
      $stmt = self::connect()->prepare("SELECT email FROM account WHERE email = :email");
      $stmt->bindParam(':email', $email);
      $stmt->execute();

      return (bool) $stmt->fetch();

    } catch (PDOException $e) {
      self::error("db_error", $e->getCode(), $e->getMessage());
    }
  }

  public static function getRecruiterCharacters()
  {
    try {
      $stmt = self::connect()->prepare("SELECT c.name FROM acore_characters.characters c LEFT JOIN acore_playerbots.playerbots_account_type pat ON pat.account_id = c.account WHERE COALESCE(pat.account_type, 0) = 0 ORDER BY c.name");
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      self::error("db_error", $e->getCode(), $e->getMessage());
    }
  }

  public static function getRecruiterAccountId($characterName)
  {
    try {
      $stmt = self::connect()->prepare("SELECT c.account FROM acore_characters.characters c LEFT JOIN acore_playerbots.playerbots_account_type pat ON pat.account_id = c.account WHERE c.name = :characterName AND COALESCE(pat.account_type, 0) = 0 LIMIT 1");
      $stmt->bindParam(':characterName', $characterName);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result ? (int) $result['account'] : false;

    } catch (PDOException $e) {
      self::error("db_error", $e->getCode(), $e->getMessage());
    }
  }

  public static function Register($username, $email, $salt, $verifier, $recruiter = 0)
  {
    try {
      $stmt = self::connect()->prepare("INSERT INTO account (username, email, salt, verifier, recruiter) VALUES (:username, :email, :salt, :verifier, :recruiter)");
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':salt', $salt);
      $stmt->bindParam(':verifier', $verifier);
      $stmt->bindParam(':recruiter', $recruiter, PDO::PARAM_INT);
      $stmt->execute();

      return true;
    } catch (PDOException $e) {
      self::error("db_error", $e->getCode(), $e->getMessage());
    }
  }
}

?>