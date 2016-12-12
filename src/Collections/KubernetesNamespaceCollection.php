<?php namespace Maclof\Kubernetes\Collections;

use Maclof\Kubernetes\Models\KubernetesNamespace;

class KubernetesNamespaceCollection extends Collection
{
	/**
	 * The constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		parent::__construct($this->getKubernetesNamespaces(isset($data['items']) ? $data['items'] : []));
	}

	/**
	 * Get an array of KubernetesNamespaces.
	 *
	 * @param  array  $items
	 * @return array
	 */
	protected function getKubernetesNamespaces(array $items)
	{
		foreach ($items as &$item) {
			$item = new KubernetesNamespace($item);
		}

		return $items;
	}
}
