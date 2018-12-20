<?php
/**
 * Action
 */
class action
{
	// Atributos
	public $file;
	// Métodos Especiais
	public function __construct()
	{
		$_SESSION['token'] = !isset($_SESSION['token']) ? md5(time()) : $_SESSION['token'];

		$this->file = str_replace("index.php", "", $_SERVER['SCRIPT_FILENAME']);
	}
	// Métodos
	public function PageHome()
	{
		$file = str_replace("controller", "", __DIR__);
		$cofig = parse_ini_file( $file.'config.ini', true );
		
		include_once($this->file.'view/home.phtml');

		return false;
	}
	public function PageEmail(){
		$file = str_replace("controller", "", __DIR__);
		$cofig = parse_ini_file( $file.'config.ini', true );

		$quiz_i = isset($_SESSION['quiz_i']) ? $_SESSION['quiz_i'] : 0;
		$quiz_c = isset($_SESSION['quiz_c']) ? $_SESSION['quiz_c'] : 0;
		$quiz_a = isset($_SESSION['quiz_a']) ? $_SESSION['quiz_a'] : 0;
		$quiz_o = isset($_SESSION['quiz_o']) ? $_SESSION['quiz_o'] : 0;

		$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Não Informado';
		$idade = isset($_SESSION['idade']) ? $_SESSION['idade'] : 18;
		
		include_once($this->file.'view/email/email.phtml');

		return false;
	}
	public function PageQuiz($id)
	{
		require_once($this->file.'controller/class.quiz.php');

		$quiz = new quiz($id);
		$log = $quiz->getQuiz();
		
		if($log) return true;
		else return $this->fileNotFind();
	}
	public function PageResult(){
		$file = str_replace("controller", "", __DIR__);
		$cofig = parse_ini_file( $file.'config.ini', true );

		$quiz_i = isset($_SESSION['quiz_i']) ? $_SESSION['quiz_i'] : 0;
		$quiz_c = isset($_SESSION['quiz_c']) ? $_SESSION['quiz_c'] : 0;
		$quiz_a = isset($_SESSION['quiz_a']) ? $_SESSION['quiz_a'] : 0;
		$quiz_o = isset($_SESSION['quiz_o']) ? $_SESSION['quiz_o'] : 0;
		
		include_once($this->file.'view/home/statistics.phtml');

		return false;
	}
	public function PageSetResult(){
		require_once($this->file.'controller/class.result.php');
		$result = new result();

		return true;		
	}
	public function fileNotFind()
	{
		header('HTTP/1.0 404 Not Found');
		include_once($this->file.'view/404.phtml');

		return false;
	}
}