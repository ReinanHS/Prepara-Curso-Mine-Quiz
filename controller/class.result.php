<?php
/**
 * Verificação de conta
 */
class result
{
	// Atributos
	public $token;
	public $quiz_i;
	public $quiz_c;
	public $quiz_a;
	public $quiz_o;
	public $nome;
	public $idade;
	// Métodos Especiais
	public function __construct()
	{
		$this->token 	= $_POST['token'];

		$this->quiz_i 	= $_POST['i'];
		$this->quiz_c 	= $_POST['c'];
		$this->quiz_a 	= $_POST['a'];
		$this->quiz_o 	= $_POST['o'];
		
		$this->nome 	= $_POST['nome'];
		$this->idade 	= $_POST['idade'];
	}
	// Métodos
	public function valida(){
		if($_SESSION['token'] == $this->token){ return true; }
		else return false;
	}
	public function getEmailHTML(){
		$file = str_replace("controller", "", __DIR__);
		$cofig = parse_ini_file( $file.'config.ini', true );

		$url = ($cofig['main']['url'].'get/email/');
		
		$url = $url.urlencode($this->nome).'WPV';
		$url = $url.$this->idade.'WPV';

		$url = $url.$this->quiz_i.'WPV';
		$url = $url.$this->quiz_c.'WPV';
		$url = $url.$this->quiz_a.'WPV';
		$url = $url.$this->quiz_o;

		return file_get_contents($url);
	}
	public function email()
	{
		$file = str_replace("controller", "", __DIR__);
		$cofig = parse_ini_file( $file.'config.ini', true );
		$html = $this->getEmailHTML();
		$mail = new PHPMailer(true);
		try {
		    //Server settings
		    $mail->SMTPDebug = false;                            // Enable verbose debug output
		    $mail->do_debug = 0;
		    $mail->isSMTP();                                    // Set mailer to use SMTP # yiwip@khtyler.com reinan5353@cliptik.net
		    $mail->Host = $cofig['email']['host'];  			// Specify main and backup SMTP servers
		    $mail->SMTPAuth = $cofig['email']['sMTPAuth'];      // Enable SMTP authentication
		    $mail->Username = $cofig['email']['username'];      // SMTP username
		    $mail->Password = $cofig['email']['password'];      // SMTP password
		    $mail->SMTPSecure = $cofig['email']['sMTPSecure'];  // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = $cofig['email']['port'];              // TCP port to connect to
		    //Recipients
		    $mail->setFrom($cofig['email']['username'], 'Prepara Cursos Simão Dias');
		    //$mail->addAddress('preparacursos.sd.2017@gmail.com', 'ReinanHS');     		// Add a recipient
		    $mail->addAddress('reinangabriel1520@gmail.com', 'ReinanHS');     		// Add a recipient
		    //Content
		    $mail->isHTML(true);                                  	// Set email format to HTML
		    $mail->Subject = 'Análise comportamental!';
		    $mail->Body    = $html;
		    $mail->AltBody = 'Obrigado pela atenção!';
		    $mail->send();
		    
			return true;

		} catch (Exception $e) {
			header('HTTP/1.0 303 Erro ao enviar email');
            echo "Não foi possível enviar o e-mail.";
  			echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
			return false;
		}

		//echo $this->getEmailHTML();
	}
}
?>