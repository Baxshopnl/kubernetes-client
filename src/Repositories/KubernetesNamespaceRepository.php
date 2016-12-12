<?php namespace Maclof\Kubernetes\Repositories;

use Maclof\Kubernetes\Collections\KubernetesNamespaceCollection;

class KubernetesNamespaceRepository extends Repository
{
	protected $uri = 'namespaces';

	protected function createCollection($response)
	{
		return new KubernetesNamespaceCollection($response);
	}

    /**
     * Get a collection of items. (disable namespace)
     *
     * @return \Maclof\Kubernetes\Collections\Collection
     */
    public function find()
    {
        if ($this->beta) {
            $response = $this->client->sendBetaRequest('GET', '/' . $this->uri, null, null, false);
        } else {
            $response = $this->client->sendRequest('GET', '/' . $this->uri, null, null ,false);
        }

        $this->resetParameters();

        return $this->createCollection($response);
    }

}
