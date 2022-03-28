<?php

namespace App;

class ReqresWrapper
{
    const BASE_URL = 'https://reqres.in/api/';

    private function call ($endpoint, $data = null)
    {
        $url = self::BASE_URL . $endpoint;

        if ($data !== null)
            $url .= http_build_query($data);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($curl);
        curl_close($curl);

        return json_decode($output);
    }

    public function getUsers ()
    {
        return $this->call('users');
    }

    public function getAllUsers ()
    {
        $users = array();

        $res = $this->call('users');

        foreach ($res->data as $user)
            $users[] = $user;

        for ($page = 1; $page < $res->total_pages; $page++) {
            $res = $this->call('users', array('page' => $page));

            foreach ($res->data as $user)
                $users[] = $user;
        }

        return $users;
    }
}