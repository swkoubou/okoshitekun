<?php
class Controller_Input extends \Fuel\Core\Controller
{
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
}