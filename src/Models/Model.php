<?php namespace Maclof\Kubernetes\Models;

abstract class Model
{
	/**
	 * The schema.
	 *
	 * @var array
	 */
	protected $schema = [];

	/**
	 * The api version.
	 *
	 * @var string
	 */
	protected $apiVersion = 'v1';

	/**
	 * The attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * The constructor.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes = array())
	{
		$this->attributes = $attributes;
	}

	/**
	 * Get the model as an array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return $this->attributes;
	}

	/**
	 * Get some metadata.
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function getMetadata($key)
	{
        return $this->getData('metadata', $key);
    }

	/**
	 * Get some specdata.
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function getSpecdata($key)
	{
        return $this->getData('spec', $key);
	}

	/**
	 * Get some specdata.
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function getStatusdata($key)
	{
		return $this->getData('status', $key);
	}

    /**
     * @param $space
     * @param $item
     * @return mixed
     * @throws \Exception
     */
	protected function getData($space, $item)
    {
        $result = "";

        if ($item === null || empty($item)) {
            $result = $this->attributes[$space];
        } else {
            if (array_key_exists($item, $this->attributes[$space])) {
                $result = $this->attributes[$space][$item];
            } else {
                $keys     = explode('.', $item);
                $lookup   = $this->attributes[$space];
                $foundAny = false;
                foreach ($keys as $key) {
                    if (isset($lookup[$key])) {
                        $foundAny = true;
                        $lookup   = $lookup[$key];
                    }
                }
                if ($foundAny === true) {
                    $result = $lookup;
                }
            }
        }

        return $result;
    }

	/**
	 * Get the schema.
	 *
	 * @return string
	 */
	public function getSchema()
	{
		$this->schema['kind'] = basename(str_replace('\\', '/', get_class($this)));
		$this->schema['apiVersion'] = $this->apiVersion;

		$schema = array_merge($this->schema, $this->toArray());

		return json_encode($schema, JSON_PRETTY_PRINT);
	}

	/**
	 * Get the model as a string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->getSchema();
	}

}
