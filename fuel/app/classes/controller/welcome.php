<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Welcome extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
	    //$data viewに渡す連想配列
        $data = array();
        /*中身
            $rows = [
                "date" => "YYYY-mm-dd",
                "one"  => "text",
                "two"  => "text",
                "three"  => "text",
                "four"  => "text",
                "five"  => "text",
            ]
        */
        $data['rows'] = Model_Okoshite::find_one_by('date',Date::time()->format("%Y-%m-%d"));
        return View::forge('welcome/okoshitekun',$data);
	}

	public function action_input(){
	    return View::forge('welcome/okoshiteinput');
    }

    public function action_dbsetup(){
	    //Viewに渡す配列を作成
	    $data = array();
	    //DBを用意する
	    try
        {
            DBUtil::create_database('okoshiteDB', 'utf8');
            $data['dbstate'] = 'success';
        }
        catch(\Database_Exception $e)
        {

            $data['dbstate'] = $e;
        }

        //Tableを用意する
        if(DBUtil::table_exists('okoshiteTable'))
        {
            $data['tablestate'] = 'Already exists';
        }
        else
        {
            try
            {
                DBUtil::create_table(
                    'okoshiteTable',
                    array(
                        'date' => array('type' => 'date', 'null' => 'false'),
                        'one'  => array('constraint' => 100, 'type' => 'varchar'),
                        'two'  => array('constraint' => 100, 'type' => 'varchar'),
                        'three'  => array('constraint' => 100, 'type' => 'varchar'),
                        'four'  => array('constraint' => 100, 'type' => 'varchar'),
                        'five'  => array('constraint' => 100, 'type' => 'varchar'),
                    ), array('date')
                );

            }
            catch(\Database_Exception $e)
            {
                $data['tablestate'] = 'APPPATH/config/development/db.phpにdbnamreを追加してください';
            }

            //APPPATH/config/development/db.php に接続設定を書いてから実行でサンプルデータ挿入
            /*
            $new = Model_Okoshite::forge();
            $new->date = '0000-00-00';
            $new->one = 'hoge';
            $new->two = 'fuga';
            $new->three = 'foo';
            $new->four = 'bar';
            $new->five = 'piyo';
            $new->save();
            */
        }

        return View::forge('welcome/dbsetup',$data);
    }

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response

	public function action_hello()
	{
		return Response::forge(Presenter::forge('welcome/hello'));
	}


	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}