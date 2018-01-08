<?php
namespace Home\Controller;

use Think\Controller;
class TemplateController extends Controller
{
    public function index ()
    {
        $this->display('index');
    }

    public function products ()
    {
        $this->display('products');
    }

    public function purchase ()
    {
        $this->display('purchase');
    }
}