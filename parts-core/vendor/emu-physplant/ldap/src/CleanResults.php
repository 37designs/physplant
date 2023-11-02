<?php

namespace EMUPhysPlant\LDAP;

trait CleanResults {

	/**
	 * Recursively cleans an array returned from ldap_get_entries
	 *
	 * @param array $results
	 *
	 * @return array
	 */
	public function cleanLdapGetEntriesResults($results)
	{
		$returnArray = [];

		for ($i = 0; $i < $results['count']; $i++) {

			if (is_array($results[$i])) {
				$returnArray[$results[$i]['dn']] = $this->cleanLdapGetEntriesResults($results[$i]);
			} else {
				$attribute = $results[$i];
				if ($results[$attribute]['count'] == 1) {
					$returnArray[$attribute] = $results[$attribute][0];
				} else {
					for ($j = 0; $j < $results[$attribute]['count']; $j++) {
						$returnArray[$attribute][] = $results[$attribute][$j];
					}
				}
			}

		}

		return $returnArray;
	}
}