<?php
namespace gift\appli\app\actions;

class GetCategorieController
{
    public function __invoke($request, $response, $args)
    {
        $categories = [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2'],
            ['id' => 3, 'name' => 'Category 3']
        ];

        $basePath = "/Architecture_Logicielle/Architecture-Logicielle/gift.appli/public";

        $html = <<<HTML
        <h1>Categories</h1>
        HTML;
        foreach ($categories as $category) {
            $url = $basePath . '/categorie/' . $category['id'];
            $html .= <<<HTML
            <p><a href="$url">ID: {$category['id']}, Name: {$category['name']}</a></p>
            HTML;
        }

        $response->getBody()->write($html);
        return $response;
    }
}