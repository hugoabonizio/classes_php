<?
class Blob extends DB {
	function read($fname) {
		return array('data' => (DB::get('data', '`blob`', "MD5(fname) = '" . $fname . "'")), 'type' => DB::get('type', '`blob`', "MD5(fname) = '" . $fname . "'"));
	}
	function write($fname, $data, $type) {
		if (DB::countregisters('`blob`', "fname = '" . $fname . "'")) {
			DB::update('`blob`', array('`fname`' => $fname, '`data`' => $data, '`type`' => $type), "fname = '" . $fname . "'");
		} else {
			DB::insert('`blob`', array('`fname`' => $fname, '`data`' => $data, '`type`' => $type));
		}
	}
	function clear($fname) {
		DB::delete('blob', "fname = '" . $fname . "'");
	}
}