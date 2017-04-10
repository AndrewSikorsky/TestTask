<?php 

$mysqli = new mysqli('localhost','root','66677666','test_task_2');
//$mysqli = new mysqli('host','username','password','database_name');

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}



echo '<h2>a)Для заданного списка товаров получить названия всех категорий, в которых представлены товары</h2>';
$productsList = [3,7,9];
echo 'Список товаров: '. implode(',',$productsList);
$categoriesWithProducts = $mysqli->query("
    SELECT * FROM categories c JOIN products_to_categories ptc ON (c.id = ptc.category_id) WHERE ptc.product_id IN (".implode(',',$productsList).") GROUP BY ptc.category_id
");

foreach($categoriesWithProducts as $cat) {
    echo '<p> ID'. $cat['id'] . ' - '  . $cat['name'] .'</p>';
}







echo '<h2>b) Для заданной категории получить список предложений всех товаров из этой категории и ее дочерних категорий;</h2>';

function fetchItemsByCat($cat, $results = [], $mys) {
    $itemsInCat = $mys->query("SELECT * FROM products p INNER JOIN products_to_categories ptc ON ptc.product_id = p.id WHERE ptc.category_id = $cat");

    while($row = mysqli_fetch_array($itemsInCat))
        array_push($results, $row['name']);

    $subCategories = $mys->query("SELECT id FROM categories WHERE parent_id = $cat");
    while($row = mysqli_fetch_array($subCategories))
        $results = fetchItemsByCat($row['id'], $results ,$mys);

    return $results;
}

$startCat = 3;
echo '<h4>Начальная категория: ' .$startCat. '</h4>';
echo '<h4>Ожидаемый результат: Категория 3(товар: 3) -> Категория 9(товар: 3,9) -> Категория 10(товар: 3,9,10) -> Категория 12 (товар: 7) | Уникальные: 3, 9, 10, 7 </h4>';
$itemsInCat = fetchItemsByCat($startCat, [], $mysqli);
foreach(array_unique($itemsInCat) as $product => $val) {
    echo '<p>'. $val . '</p>';
}










echo '<h2>c)Для заданного списка категорий получить количество предложений товаров в каждой категории;</h2>';

$categoriesList = [3, 5, 9, 12];
echo 'Список категорий: ' . implode(', ',$categoriesList);
$c_task = $mysqli->query("SELECT *, COUNT(*) as num_items FROM products p INNER JOIN products_to_categories ptc ON ptc.product_id = p.id WHERE ptc.category_id IN(".implode(',',$categoriesList).") GROUP BY category_id");
foreach($c_task as $product) {
    echo '<p> Категория '. $product['category_id'] . ' - Кол-во товаров: '  . $product['num_items'] .'</p>';
}











echo '<h2>d)Для заданного списка категорий получить общее количество уникальных предложений товара;</h2>';

echo 'Список категорий: ' . implode(', ',$categoriesList);
$d_task = $mysqli->query("SELECT * FROM products p INNER JOIN products_to_categories ptc ON ptc.product_id = p.id WHERE ptc.category_id IN(".implode(',',$categoriesList).") GROUP BY p.id");
$sum = 0;
foreach($d_task as $product) {
    $sum++;
    echo '<p> Категория '. $product['category_id'] . ' - '  . $product['name'] .'</p>';
}
//$sum = 0;
//foreach(array_unique($d_task) as $product) {
//    $sum++;
//}
echo '<p> Общее количество уникальных товаров: '  . $sum .'</p>';














echo '<h2>d)Для заданной категории получить ее полный путь в дереве (breadcrumb, «хлебные крошки»)</h2>';

function getCategoryTreeIDs($catID, $mys) {
    $subCategories = $mys->query("SELECT parent_id, name FROM categories WHERE id = '$catID'");
    $path = [];
    while($row = mysqli_fetch_array($subCategories)) {
            $path[] = $row['name'];
            $path = array_merge(getCategoryTreeIDs($row['parent_id'], $mys), $path);
    }
    return $path;
}

function showCatBreadCrumb($catID, $mys) {
    $array = getCategoryTreeIDs($catID, $mys);

    $numItems = count($array);
    foreach ($array as $id => $name) {
        if($id == $numItems-1) {
            echo $name;
        } else {
            echo $name . ' &raquo; ';
        }
    }
}
$breadCat = 12;
$bread = showCatBreadCrumb($breadCat, $mysqli);