# Pulse

Pulse allows you to easily write healthchecks for your application and display a simple, aggregated report so you can quickly diagnose whether and why your app is having trouble (or whether you can blame someone else). You can also monitor your healthchecks with [nagios](http://www.nagios.org/), [zabbix](http://www.zabbix.com/), etc.

[![Build Status](https://travis-ci.org/cbednarski/pulse.png)]
(https://travis-ci.org/cbednarski/pulse)

#### Wait, what's a healtcheck?

Healthchecks are a great way to test system health and connectivity to other services. For example, you can verify connectivity to memcache or mysql, that your app can read / write to certain files, or that your API key for a third-party service is still working.

## Example Usage

`healthcheck.php`

```php

$pulse = new cbednarski\Pulse\Pulse();

$pulse->add("Check that config file is readable", function(){
	return is_readable('/path/to/my/config/file');
});

# include '/path/to/my/config/file';
$config = array(
	'memcache_host' => '127.0.0.1',
	'memcache_port' => 11211
);

$pulse->add("Check memcache connectivity", function() use ($config) {
	$memcache = new Memcache();
	if(!$memcache->connect($config['memcache_host'], $config['memcache_port'])){
		return false;
	}
	$key = 'healthcheck_test_key'
	$msg = 'memcache is working';
	$memcache->set($key, $msg);
	return $memcache->get($key) === $msg;
});

$pulse->check();
```

## Special Features

Pulse can be run via command-line, accessed via the browser, or used with tools like CURL.

Pulse automatically detects whether you're running from a browser, commandline, or CURLy interface and responds with html, json, or plaintext as appropriate.

To enable json-y goodness, you'll need to send `Accept: application/json`. E.g:

	$ curl -H "Accept: application/json" http://example.com/healthcheck.php

## Does Pulse Work With X?

Yep. Pulse is designed to be self-contained and is very simple, so it doesn't require you to use any particular framework. You are free to include other things like yml parsers, etc. if you choose, but we recommend NOT including a full framework stack on top of it. If the framework fails to load for some reason, your healthchecks won't be displayed, meaning they're not useful for diagnosing whatever problem you've encountered.

## Won't This Expose Information About My App?

Potentially. You *probably* don't want to display the healthcheck results to the public. Instead, you could [whitelist certain IPs](http://httpd.apache.org/docs/2.2/howto/access.html).