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

Na construção, você deve passar o caminho base do url. Após isso, você deve ser adicionar as regras usando o adiciona(). 
valida() checa se todas as validações derão certo, e o método retornaURLErros, retorna a URL para ser utilizada no redirecionamento.