# Inicio Rápido de app

Para criação de um novo site com login

## Mensagens

É possível exibir mensagens de aviso. Esse recurso pode ser utilizado para validações e avisos. Ele utiliza os alerts do bootstrap- Para isso deve-se:

  - Informar na url a query mensagens. Ex api\teste?mensagens=1%2. Caso seja mais de uma mensagem separar por %.
  - Para adicionar um novo codigo, adicione ao JSON src\Utils\Mensagem\Mensagem.json
  - Deve-se adicionar ao modelo do twig {{ include('mensagens.twig') }} para exibir as mensagens na tela

## Classes

### App\Validacao\ValidacaoRedireciona

Serve para verificar se a algum erro e gerar uma url com os erros para podermos redirecionar para o site de tratamentos.

#### Método __construct($url)
Na construção, você deve passar o caminho base do url através do parametro $url, pode usar pathfor para obter link por nome da rota

#### Método adiciona($regra, $codRegra)
Você deve ser adicionar as regras usando o adiciona().

O parametro regra você deve passar true ou false onde true irá passar, aqui recomenda-se usar o que você irá validar.

O parâmetro $codRegra, você deve passar o código da mensagens que será retornado caso a validação não seja aprovada. Use os codigos de Mensagem.json.

#### Método valida()
Checa se todas as validações derão certo e retorna true caso esteja todas corretas ou false caso alguma não esteja correta.

#### Método retortnaURLErros()
Retorna a URL com as mensagens de erro, pode ser usada em conjunto com $response->withRedirect();

#### Exemplo

```php
use App\Validacao\ValidacaoRedireciona;

$validacao = new ValidacaoRedireciona(
  $this->router->pathFor(
    'nome-rota',
     array ('id' => $id_rota) //Opcional
  )
);

/**
 * A regra deve ser um boleano onde true passa e false para
 **/
$validacao->adicionaRegra($regra1, $codErro);
$validacao->adicionaRegra($regra2, $codErro);

if (!$validacao->valida()) {
  return $response->withRedirect($validacao->retornaURLErros());
}
```

### Utils\TwigUtils\TwigInputs

Serve para registrar inputs entre formulários para obte-los em outra tela.

O middleware SessaoNormalMid, sempre verificará se tem inputs e registrará em TwigArgs em dados > inputForm.

#### Método registra($inputs)
Registras os inputs em $_SESSION['input']. $inputs deve ser um array com os inputs

#### Método retorna()
Retorna um array com os inputs

#### Método limpa()
Limpa os inputs em $_SESSION['input'].

### Utils\URLs\ParameterURL
Permite adicionar e retornar uma URL com parametros de URL

```php
use Utils\URLs\ParameterURL;

//Rota Base
$rota = '\teste';

$parameterURL = new ParameterURL($rota);

//Adiciona valor a parametro alpha
$parameterURL->add('alpha', 'a');

//Adiciona valor b, parametro betha
$parameterURL->add('betha', 'b');

//Adiciona valor 1, parâmetro alpha
$parameterURL->add('alpha', 1);

//retorna \teste?&alpha=a%1&betha=b
echo $parameterURL->returnURL();
```

## Proteção CSRF
Para evitar ataques CSRF, utilizamos o componente slim/csrf.

Em cada controller de formulário deve ser colocado o seguinte trecho de código antes do render.

```php
$csrf = new ArrayCSRF(
  $this->csrf->getTokenNameKey(),
  $this->csrf->getTokenValueKey(),
  $request
);
$this->twigArgs->adcDados('csrf', $csrf->getCSRF());
```

No template do controller, deve-se colocar o seguinte código.

```twig
{{ include('includes/csrf.twig') }}
```

## Dados de sessão
É possível obter dados da sessão no template usando a palavra sessao.

Dados disponíveis: id, email

Exemplo:
{{ sessao.email }} - Retorna o email do usuário da sessão

## Envio de e-mail
Para testes de envio de email foi escolhido o serviço mailTrap

Para envio de email foi escolhido o componente SwiftMailer

