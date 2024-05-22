<?php
namespace gift\appli\app\actions;

class GetCategorieIdController
{
    public function __invoke($request, $response, $args)
    {
        $id = $args['id'];
        $categories = [
            ['id' => 1, 'name' => 'Category 1'],
            ['id' => 2, 'name' => 'Category 2'],
            ['id' => 3, 'name' => 'Category 3']
        ];

        $category = array_filter($categories, function($cat) use ($id) {
            return $cat['id'] == $id;
        });

        if (empty($category)) {
            $response->getBody()->write("Category not found");
            return $response->withStatus(404);
        }

        $category = array_shift($category);

        $html = <<<HTML
        <h1>Category</h1>
        <p>ID: {$category['id']}, Name: {$category['name']}</p>
        HTML;

        $response->getBody()->write($html);
        return $response;
    }
}