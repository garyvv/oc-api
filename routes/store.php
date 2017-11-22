<?php
$router->group(['prefix' => 'v1'], function () use ($router){
    $router->get('categories', 'CategoryController@index');
    $router->get('categories/{categoryId}/products', 'CategoryController@products');

    $router->get('products', 'ProductController@index');
    $router->get('products/{productId}', 'ProductController@detail');
    $router->get('scans/{barCode}', 'ProductController@scan');

    $router->get('banners', 'HomeController@banner');

    $router->get('keywords', 'HomeController@keywords');

    $router->get('sales/products', 'ProductController@sales');

    $router->post('login', 'LoginController@login');
});

Route::post('v1/scans', function() {
    $data = [
        'name' => '儿童玩具车',
        'images' => ['/images/common/index-toy.png'],
        'price' => 18.5,
        'in_price' => 8,
        'multi_price' => 14,
        'quantity' => 10,
        'description' => '儿童玩具车的详细描述就是价格为比较优惠，双十一力度',
        'category' => ['乐高', '嘉嘉乐']
    ];

    $result = [
        'code' => 1001,
        'msg' => '请求成功',
        'data' => $data
    ];

    echo json_encode($result);
});
Route::get('v1/scans', function() {
    $data = [
        'name' => '儿童玩具车',
        'images' => ['/images/common/index-toy.png'],
        'price' => 18.5,
        'in_price' => 8,
        'multi_price' => 14,
        'quantity' => 10,
        'description' => '儿童玩具车的详细描述就是价格为比较优惠，双十一力度',
        'category' => ['乐高', '嘉嘉乐']
    ];

    $result = [
        'code' => 1001,
        'msg' => '请求成功',
        'data' => $data
    ];

    echo json_encode($result);
});

