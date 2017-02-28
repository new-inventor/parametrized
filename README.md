#Parametrized

Трейт для добавления функционала параметров к классу

##Установка

через composer

`composer require new-inventor/parametrized`

##Принцип работы

Подключаем трейт к классу

`use Parametrized;`

Прописываем статический параметр 

`$defaults = [<name> => <value>];`

все.

Теперь можно устанавливать параметры несколькими способами:

```
class MyParams {
    use Parametrized;
    protected static $defaults = [
        'name' => '',
        'description' => null,
    ];
}


$params = new MyParams();
$params->load([
    'name' => 'Name',
    'description' => 'null,
]);

$params->name = 'Jack';
$params->name('Max');
```

Также есть несколько полезных функций 

```
//преобразует параметры в массив
$params->toArray();

//Создает отображение параметров в другой массив.
$params->map(
    [
        'name' => 'title', 
        'description' => 'descr'
    ],
    false
);


```