<?php

namespace app\common\ding;

use FormComponentPropVo;
use FormComponentVo;

/**
 * 钉钉表单组件
 * Class Form
 * @package app\common\ding
 */
class Form
{
    /**
     * 单行输入框
     * @return FormComponentVo
     */
    public static function singleInput()
    {
        $singleInput = new FormComponentVo;
        $singleInput->component_name="TextField";
        $props = new FormComponentPropVo;
        $props->id="TextField-J78F056R";
        $props->label="3单行0输入框1";
        $props->required=true;
        $props->placeholder="请输入222";
        $singleInput->props = $props;
        return $singleInput;

    }
    /**
     * 多行输入框
     * @return FormComponentVo
     */
    public static function multipleInput()
    {
        $multipleInput = new FormComponentVo;
        $multipleInput->component_name="TextareaField";
        $props = new FormComponentPropVo;
        $props->id="TextareaField-J78F057R";
        $props->label="1duo行输入框";
        $props->required=true;
        $props->placeholder="请输入";
        $multipleInput->props = $props;
        return $multipleInput;
    }
    public static function moneyComponent()
    {
        $moneyComponent =  new FormComponentVo;
        $moneyComponent->component_name="MoneyField";
        $props = new FormComponentPropVo;
        $props->id="MoneyField-J78F057m";
        $props->label="金额(元)大写";
        $props->required=true;
        $props->placeholder="请输入";
        $moneyComponent->props = $props;
        return $moneyComponent;
    }
}