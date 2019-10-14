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
                "one"  => "varchar(100)",
                "two"  => "varchar(100)",
                "three"  => "varchar(100)",
                "four"  => "varchar(100)",
                "five"  => "varchar(100)",
            ]
        */
        $data['rows'] = Model_Okoshite::find_by_pk(Date::time()->format("%Y-%m-%d"));
        return View::forge('welcome/okoshitekun',$data);
	}

	public function action_input()
    {
	    $data = array();
	    //宿泊メンバーで初期化
        $kouboumin = array('hoge','huga','hogehoge','hugehuge','foo','bar');
	    $data['kouboumin'] = $kouboumin;
	    //時限数で初期化
	    $data['period'] = array('one','two','three','four','five');
	    return View::forge('welcome/okoshiteinput',$data);
    }

    public function action_dbinput()
    {
	    $data = array();

        $period = array('one','two','three','four','five');

        foreach ($period as $periods)
        {
            $data[$periods] = '';
        }

        if(!(empty($_POST['year'])) and !(empty($_POST['month'])) and !(empty($_POST['day'])))
        {
            $data['date'] = $_POST['year'].$_POST['month'].$_POST['day'];
            $kouboumin = array('hoge','huga','hogehoge','hugehuge','foo','bar');
            $db = Model_Okoshite::find_one_by('date',$data['date']);
            foreach ($period as $periods)
            {
                foreach($kouboumin as $people){
                    $incheck = Input::post($people.$periods,'');
                    if(!(empty($incheck))){
                        //dbに変更
                        $data[$periods] = $data[$periods].Input::post($people.$periods).',';
                    }
                }
            }
            if($db === NULL)
            {
                //レコードが存在しないとき
                $db = Model_Okoshite::forge()->set(array(
                    'date' => $_POST['year'].$_POST['month'].$_POST['day'],
                    'one' => $data['one'],
                    'two' => $data['two'],
                    'three' => $data['three'],
                    'four' => $data['four'],
                    'five' => $data['five'],
                ));
            }
            else
            {
                //レコードが存在するとき
                $db->one = $data['one'];
                $db->two = $data['two'];
                $db->three = $data['three'];
                $db->four = $data['four'];
                $db->five = $data['five'];
            }
            $db->save();
        }
        Response::redirect('welcome');
    }

    public function action_dbsetup()
    {
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

            $data['dbstate'] = var_dump($e);
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
