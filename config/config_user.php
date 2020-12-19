<?php
session_start();
require_once("class/class.user.php");
$login = new USER();

if($login->is_loggedin()!="")
	{
		$login->redirect('index.php');
	}
if(isset($_POST['btn-login']))
	{
		$uname = strip_tags($_POST['txt_uname_email']);
		$umail = strip_tags($_POST['txt_uname_email']);
		$upass = strip_tags($_POST['txt_password']);
			
		if($login->doLogin($uname,$umail,$upass))
		{
			$status = "Login Success !";
			$login->redirect('index.php');	
		}
		else
		{
			$status = "Dados Incorretos !";
		}	
	}
// SE FOI ENVIADO O BOTÃO btn-recover QUE SERVE PARA RECUPERAR A SENHA
if(isset($_POST['btn-recover']))
	{	
		// ENVIA TAMBÉM O E-MAIL
		$email = $_POST['txt_email'];
		// CHECA SE O E-MAIL ENVIADO ESTÁ NO FORMATO CORRETO OU É NULO
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false && $email!= "" ) 
		{
			// SE ESTIVER NO FORMATO CORRETO, CHECA SE TEM CADASTRO NO SISTEMA
			if($login->checaCadastroEmail($email))
			{
					// SE ESTIVER TUDO CORRETO, GERA A CHAVE E A DATA DE EXPIRAÇÃO.
					$codigo = base64_encode($email);
					$dt_expirar = date('Y-m-d H:i:s', strtotime('+ 1 day'));
					// CHECA SE O E-MAIL ENVIADO JÁ TEM SOLICITAÇÃO CADASTRADA NA TABELA lc_recover
					if($login->ChecaValidadeCodigo(base64_decode($codigo),$dt_expirar))
					{
						$status = "Já existe codigo enviado. verifique seu e-mail!";
					} else {
							if($login->inserecodigo($codigo,$dt_expirar))
							{
							//$login->redirect('recuperar.php');
							// CASO INCORRETO, MOSTRA O ERRO
							require 'PHPMailer/class.phpmailer.php';
							require 'PHPMailer/class.smtp.php';
							

							$mail = new PHPMailer;
								$mail->CharSet = 'UTF-8'; // Charset da mensagem
								$mail->SMTPDebug = 3; // Debug
								$mail->isSMTP(); // Seta para usar SMTP
								$mail->Host = "http://localhost"; // SMTP Server
								$mail->SMTPAuth = true; // Libera a autenticação
								$mail->Username = 'rubenscouto@gmail.com'; // Usuário SMTP
								$mail->Password = '1n234H1AxbTec'; // Senha do usuário
								$mail->SMTPSecure = "tls"; // Acesso com TLS exigido pelo 
								$mail->Port = 587; 
								$mail->FromName = 'Rubens Admin do Sistema';
								$mail->From = $email;
								$mail->addAddress('rubenscouto@gmail.com', 'Sr. Rubens'); // Email e nome do destino
								$mail->isHTML(true); // Seta o envio em HTML
								$mail->Subject = 'Recuperação de Senha'; // Título da mensagem
								$mail->Body = '<b><a href="http://localhost/Login-Signup-Pdo/recuperar.php?codigo=' . $codigo . '">Redefinir</a></b>'; // Mensagem
								$mail->AltBody = 'Ative o HTML da sua conta.'; // Mensagem alternativa

								if($mail->Send()){
									$status = 'e-mail enviado.';
								}else {
									$status = 'erro ao enviar e-mail.';
									var_dump($mail);
								}
								
							/*	
							$mail->SetLanguage('br'); // Traduzir para pt-BR
							
							$mail->SMTPAutoTLS = false; 

							//$mail->Port = 587; // Porta do SMTP

							$mail->setFrom('rubenscouto@gmail', 'Nome'); // Email e nome de quem enviara o e-mail
							$mail->addReplyTo('rubenscouto@gmail', 'Nome'); // E-mail e nome de quem responderá o e-mail

							
							//$mail->addCC('copia@dominio.com.br'); // Enviar cópiar do e-mail
							//$mail->addBCC('copiaoculta@dominio.com.br'); // Enviar uma cópia oculta

							//$mail->addAttachment('image.jpg', 'imagem.jpg'); // Anexa um arquivo

							
							
							
							
							
							$enviar = $mail->send(); // Envia e-mail

							if($enviar):
								echo 'Mensagem enviada com sucesso!';
							else:
								echo 'Erro ao enviar mensagem!<br>';
								echo 'Erro: '.$mail->ErrorInfo;
							endif;
						}catch(Exception $e){
							echo 'Erro ao enviar mensagem!';
							echo 'Erro: '.$mail->ErrorInfo;
						}
						*/
					} else {
						$status = "erro na inserção do codigo";
					}
					}
					// COMPARA O CODIGO DA TABELA lc_recover COM O E-MAIL ENVIADO. SE FOR IGUAL, EMITE A MENSAGEM DE PEDIDO CADASTRADO
					// CASO CONTRÁRIO, INSERE O CODIGO NA TABELA "lc_recover"
					
						
					/*
					$headers = "MIME-Version: 1.1 \n";
					$headers .= "Content-type: text/plain; charset=iso-8859-1 \n";
					$headers .= "From: $admin \n";
					$headers .= "Return-Path: $email\n";
					$headers .= "Reply-To: $email\n";
					
					
						// SE O CODIGO FOI GERADO, REDIRECIONA PARA A PAGINA DE RECUPERAÇÃO
						
					
					$mensagem = '<p>Recuperação de senha. Clique no Link abaixo<br />';
					$mensagem .= '<a href="http://localhost/Login-Signup-Pdo/recuperar.php?codigo=' . $codigo . '">Redefinir</a></p>';
					$admin = 'root@localhost';
					*/
					
				// CASO O E-MAIL NÃO TENHA CADASTRO NO SISTEMA, MOSTRA A MENSAGEM NA TELA	
			} else {
				$status = "Este E-mail Não Consta em nosso Cadastro.";
			}
		// SE O FORMATO DE E-MAIL NÃO ESTIVER CORRETO, MOSTRA A MENSAGEM NA TELA
		} else {
			$status = "Formato de E-mail Inválido!";
		}
	}
if(isset($_POST['btn-alter']))
	{	
		if(isset($_GET['codigo']))
			{
			/*
			$codigo = $_GET['codigo'];
			echo $codigo;
			*/
		} else {
			
		}
	}


?>