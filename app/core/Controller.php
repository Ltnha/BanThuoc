<?php

class Controller
{
    /**
     * Load Model
     */
    protected function model($model)
    {
        $modelPath = APPROOT . "/models/" . $model . ".php";

        if (!file_exists($modelPath)) {
            die("Model <b>{$model}</b> không tồn tại.");
        }

        require_once $modelPath;

        return new $model();
    }

    /**
     * Load View
     */
    protected function view($view, $data = array())
    {
        $viewPath = APPROOT . "/views/" . $view . ".php";

        if (!file_exists($viewPath)) {
            die("View <b>{$view}</b> không tồn tại.");
        }

        extract($data);

        require_once $viewPath;
    }

    /**
     * Redirect
     */
    protected function redirect($url)
    {
        header("Location: " . URLROOT . "/" . $url);
        exit;
    }
}