<?php 

	namespace Hcode\Model;

	use \Hcode\DB\Sql;
	use \Hcode\Model;

	class User extends Model{

		const SESSION = "User";

		public static function login($login, $password)
		{

			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
				":LOGIN"=>$login

			));

			if (count($results) === 0)
			{
				throw new \Exception("Usuario inexistente ou senha invalida.");	
			}

			$data = $results[0];

			if (password_verify($password, $data["despassword"]) === true)
			{

				$user = new User();
				//usando metodos magicos (da muito trabalho criar geter e setrs para cada classe...entao todo Model tera seu getrs e seters)
				$user->setData($data);

				$_SESSION[User::SESSION] = $user->getValues();

				return ($user);

			} else {
				throw new \Exception("Usuario inexistente ou senha invalida.");
				
			}		

		} 

		public static function verifyLogin()
		{

			if (
				!isset($SESSION[User::SESSION])
				||
				!$_SESSION[User::SESSION]
				||
				!(int)$_SESSION[User::SESSION]["iduser"] > 0
				||
				(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
			) {


				header("Location: /admin/login");
				exit;
			}
		}

		public static function logout()
		{

			$_SESSION[User::SESSION] = NULL;

		}

	}

 ?>