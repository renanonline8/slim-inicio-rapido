<?php
namespace Utils\ForgotPass;

use \Firebase\JWT\JWT;

use App\Models\Usuario;

/**
 * ForgotPassJwt permite gerar token e trocar senha de usuário que esqueceu a senha
 * 
 * Exceções:
 * 
 * \Firebase\JWT\ExpiredException - Quando o token estiver expirado
 * 
 * Utils\ForgotPass\ExceptionUserNotExist - Quando tentar mudar a senha de um usuário que não existir
 */
class ForgotPassJwt
{
    /**
     * Codigo secreto do token
     *
     * @var string
     */
    private $key;
    
    /**
     * Construtor da classe
     *
     * @param String $key Codigo secreto do token
     */
    function __construct(String $key)
    {
        $this->key = $key;
    }

    /**
     * Cria o token para gerar a senha
     *
     * @param String $id Id externo do usuário
     * @param \DateTime $date Data de referencia de criação do token
     * @return String
     */
    function createToken(String $id, \DateTime $date):String
    {
        $interval = new \DateInterval('P1D');
        $date->add($interval);
        $token = array(
            'iss' => $id,
            'exp' => $date->getTimestamp()
        );

        $jwt = JWT::encode($token, $this->key);

        return $jwt;
    }

    /**
     * Troca a senha do usuário
     *
     * @param [type] $token Token gerado
     * @param [type] $newPass Nova senha
     * @return void
     */
    function changePassword($token, $newPass)
    {
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $id = $decoded->iss;
        $user = Usuario::find_by_id_externo($id);
        if (empty($user)) {
            throw new ExceptionUserNotExist("User not exist", 1);
        }
        $user->senha = Usuario::hashPassword($newPass);
        $user->save();
    }
}