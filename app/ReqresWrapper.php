<?php

namespace App;

class ReqresWrapper
{
    const BASE_URL = 'https://reqres.in/api/';

    private function call ($endpoint, $data = null)
    {
        $url = self::BASE_URL . $endpoint;

        if ($data !== null)
            $url .= '?' . http_build_query($data);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);
        curl_close($curl);

        return json_decode($output);
    }

    public function getUsers ($page = 1)
    {
        return $this->call('users', array('page' => $page));
    }

    public function getAllUsers ()
    {
        $users = array();

        $res = $this->call('users');

        if (!$res)
            return null;

        foreach ($res->data as $user)
            $users[] = $user;

        for ($page = 2; $page <= $res->total_pages; $page++) {
            $res = $this->call('users', array('page' => $page));

            foreach ($res->data as $user)
                $users[] = $user;
        }

        return $users;
    }
}
