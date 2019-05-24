<?php
//引用所需文件
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class mq1{

	public function __construct($input){
		//建立一个连接通道，声明一个可以发送消息的队列hello
		$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();
		$channel->queue_declare('hello', false, false, false, false);

		while (true) {
			//定义一个消息
			$body = date('Y-m-d H:i:s') .'：'. $input;
			$msg = new AMQPMessage($body);
			$channel->basic_publish($msg, '', 'hello');

			//发送完成后打印消息告诉发布消息的人：发送成功
			echo " [x] Sent '{$body}'\n";
			usleep(100);
		}
		//关闭连接
		$channel->close();
		$connection->close();
	}

}

$params = getopt('m:');
$m = $params['m'] ?? 'a message';
(new mq1($m));