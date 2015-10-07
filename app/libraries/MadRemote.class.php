<?php

/*
 *
 * ManiaPlanet Server Data Query
 * Author: psadaic
 *
 */

class MadRemote {

	private $socket;
	private $handler = 0x80000000;

	public function __construct() {

		if(!extension_loaded("sockets"))
        {
            die("PHP sockets extension required");
        }

        if(!extension_loaded("xmlrpc"))
        {
            die("PHP xmlrpc extension required");
        }

        if(($this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)
        {
            die("Socket Error 1!");
        }
	}

	public function connect($ip, $port) {

		if(($result = socket_connect($this->socket, $ip, $port)) === false)
        {
            die("Socket Error 2!");
        }

        if(($bytes = socket_recv($this->socket, $four, 4, MSG_WAITALL)) === false)
        {
            die("Socket Error 3!");
        }

        if(($bytes = socket_recv($this->socket, $protocol, 11, MSG_WAITALL)) === false)
        {
            die("Socket Error 4!");
        }

        if($protocol !== "GBXRemote 2")
        {
            die("Unsupported protocol: ".$protocol);
        }

        return true;
	}

	public function query($methodName, $arguments = null)
    {
        $params = func_get_args();
        $method = array_shift($params);

        $xml = xmlrpc_encode_request($method, $params, array("encoding" => "utf-8", "escaping" => "cdata", "verbosity" => "no_white_space"));
        $tmp = $this->handler++;

        $bytes = pack('VVa*', strlen($xml), $tmp, $xml);

        if(($sent = socket_write($this->socket, $bytes)) === false)
        {
            die("Socket Error 5!");
        }

        if(($mix = socket_recv($this->socket, $mixbuffer, 8, MSG_WAITALL)) === false)
        {
            die("Socket Error 6!");
        }

        $array_result = unpack('Vsize/Vhandle', $mixbuffer);
        $size = $array_result['size'];
        $recvhandle = $array_result['handle'];

        if(($resp = socket_recv($this->socket, $respbuffer, $size, MSG_WAITALL)) === false)
        {
            die("Socket Error 7!");
        }

        $response = xmlrpc_decode($respbuffer, "utf-8");

        return $response;
    }

	public function __call($name, $args)
    {
        switch (count($args))
        {
            case 0:
                return $this->query($name);
            case 1:
                return $this->query($name, $args[0]);

            case 2:
                return $this->query($name, $args[0], $args[1]);

            case 3:
                return $this->query($name, $args[0], $args[1], $args[2]);

            case 4:
                return $this->query($name, $args[0], $args[1], $args[2], $args[3]);

            default:
                array_unshift($args, $name);
                return call_user_func_array(array($this, "query"), $args);
        }
    }

    public function close()
    {
        socket_close($this->socket);
    }
}

?>