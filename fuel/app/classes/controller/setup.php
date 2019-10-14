<?php
class Controller_Setup extends \Fuel\Core\Controller
{
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
}