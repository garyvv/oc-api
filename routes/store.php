<?php
$router->group(['prefix' => 'v1'], function () use ($router){
    $router->get('categories', 'CategoryController@index');
    $router->get('categories/{categoryId}/products', 'CategoryController@products');

    $router->get('products', 'ProductController@index');

    $router->get('banners', 'HomeController@banner');

    $router->get('keywords', 'HomeController@keywords');

    $router->get('sales/products', 'ProductController@sales');
});

Route::post('v1/scans', function() {
    $data = [
        'name' => '儿童玩具车',
        'price' => 18.5,
        'in_price' => 8,
        'multi_price' => 14,
        'quantity' => 10,
        'company' => '乐高'
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
        'price' => 18.5,
        'in_price' => 8,
        'multi_price' => 14,
        'quantity' => 10,
        'company' => '乐高'
    ];

    $result = [
        'code' => 1001,
        'msg' => '请求成功',
        'data' => $data
    ];

    echo json_encode($result);
});

