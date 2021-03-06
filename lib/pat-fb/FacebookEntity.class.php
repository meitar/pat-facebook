<?php
/**
 * A generic class that simplifies interacting with Facebook's objects.
 */

class FacebookEntity {
    var $FB; // Facebook PHP SDK's Facebook object
    private $id; // Facebook Graph ID
    private $friends = array();

    function FacebookEntity ($FB, $who = 'me') {
        $this->FB = $FB;
        $data = $this->FB->api("/$who");
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }

    public function getId () {
        return $this->id;
    }

    public function getFriends () {
        return $this->friends;
    }

    function loadFriends ($fields = 'id,name,gender,picture.type(square),bio,installed') {
        if (is_array($fields)) {
            $fields = implode(',', $fields);
        }
        $friends = $this->FB->api("/{$this->id}/friends?fields=$fields");
        foreach ($friends['data'] as $friend) {
            $this->friends[$friend['id']] = $friend; // set friend's ID as index
        }
    }

    function isFriendsWith ($id) {
        return array_key_exists($id, $this->friends);
    }
}
