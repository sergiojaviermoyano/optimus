<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Application specific global variables
class Globals
{
    private static $title;
    private static $title2;
    private static $dato1;
    private static $dato2;
    private static $dato3;
    private static $presu;

    private static function initialize()
    {
        if (self::$title)
            return;

        $cf = get_instance();
        $cf->load->model('Configurations');
        $data = $cf->Configurations->get_();

        self::$title = $data['conf']['title1'];
        self::$title2 = $data['conf']['title2'];
        self::$dato1 = $data['conf']['dato1'];
        self::$dato2 = $data['conf']['dato2'];
        self::$dato3 = $data['conf']['dato3'];
        self::$presu = $data['conf']['validezpresupuesto'];
    }

    /*
    public static function setAuthenticatedMemeberId($memberId)
    {
        self::initialize();
        self::$authenticatedMemberId = $memberId;
    }
    */

    public static function getTitle()
    {
        self::initialize();
        return self::$title;
    }

    public static function getTitle2()
    {
        self::initialize();
        return self::$title2;
    }

    public static function getDato1()
    {
      self::initialize();
      return self::$dato1;
    }

    public static function getDato2()
    {
      self::initialize();
      return self::$dato2;
    }

    public static function getDato3()
    {
      self::initialize();
      return self::$dato3;
    }

    public static function getPresu()
    {
      self::initialize();
      return self::$presu;
    }
}
