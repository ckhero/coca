<?php
namespace Api;

class Coca
{
	private $token = '69a63a93c06a0c52';
    const RANK_URL = 'https://konnectoruat.icoke.cn/ELearningGame/GetUserList?';
    const POINT_SAVE_URL = 'https://konnectoruat.icoke.cn/ELearningGame/SavePontInfo?';

	public function checkSign($params = [])
    {
        $paramsTmp['timestamp'] = $params['TimeStamp']?? '';
    	$paramsTmp['token'] = $this->token;
    	$paramsTmp['nonce'] = $params['Nonce']?? '';

    	$str = implode('', quickSortByAscii(array_values($paramsTmp)));
        
    	return sha1($str) == strtolower($params['signature']?? 0);
    }
    /**
     * [getSign 生成公共的参数]
     * #Author ckhero
     * #DateTime 2018-02-06
     * @return [type] [description]
     */
    public function getSign()
    {
    
        $data[] = $params['timestamp'] = time();
        $data[] = $params['token'] = $this->token;
        $data[] = $params['nonce'] = generateStr(32);

        $str = implode('', quickSortByAscii(array_values($params)));
        unset($params['token']);
        $params['str'] = $str;
        $params['signature'] = sha1($str);
        return $params;
    }

    public function ranks($page = 1, $per_page = 20)
    {   
        $params['CurrPage'] = $page;
        $params['PageCount'] = $per_page;
        $params = array_merge($params, $this->getSign());

        $res = send_curl(self::RANK_URL.http_build_query($params));

        $res = json_decode($res, true);

        $returnData['_meta'] = [
            'totalCount'=> $res['Data']['TotalCount'],
            'pageCount'=> $res['Data']['PageCount'],
            'currentPage'=> $res['Data']['CurrPage'],
        ];

        
        if ($res['Status'] != '001') {
            $returnData['items'] = [];
        }
        foreach ($res['Data']['List'] as $user) {
            $items[] = [
                'coca_id'=> $user['KOUserId'],
                'rank'=> $user['Ranking'],
                'nick_name'=> $user['NickName'],
                'points'=> $user['Points'],
                'head_img'=> $user['HeadImgUrl'],
            ];
        }
        return $returnData;
    }

    public function savePoint()
    {
        $points['Points'] = [];
        $points['Points'][] = [
            'Id'=> 11,
            'SourceId'=> 1,
            'SourceName'=> 'test',
            'GainPoint'=> 10,
            'GainTime'=> date('Y-m-d H:i:s'),
            'KOUserId'=> 100000,
        ];
        $res = send_curl(self::POINT_SAVE_URL.http_build_query($this->getSign()), json_encode($points), 'POST');
        return json_decode($res, true);
    }
 }


