<?php

namespace Xanax\Classes\Protocol;

class Internet {

	public function isValid(string $internetProtocol, string $type = ''): bool {
		switch (strtolower($type)) {
			case 'ipv4':
				$filter = FILTER_FLAG_IPV4;
				break;
			case 'ipv6':
				$filter = FILTER_FLAG_IPV6;
				break;
			default:
				$filter = null;
				break;
		}

		return boolval(filter_var($internetProtocol, FILTER_VALIDATE_IP, $filter));
	}

}
