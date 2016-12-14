<?php
/**
 * 服务调用类
 */
namespace Psf\Laravel;

class Psf
{
    /**
     * 服务分组
     *
     * @var string
     */
    private $group = '';

    /**
     * 客户端环境变量
     *
     * @var array
     */
    private $env = array();

    /**
     * 设置服务分组
     *
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        $this->group = $group;
        return $this;
    }

    /**
     * 设置客户端环境变量
     *
     * @param mixed $key
     * @param mixed $val
     * @return $this
     */
    public function env($key, $val)
    {
        if (is_array($key)) {
            $this->env = $key;
        } else {
            $this->env[$key] = $val;
        }

        return $this;
    }

    /**
     * 发起调用
     *
     * @param string $serviceName 服务名称
     * @param array $params 参数
     * @param array $constructParams 构造函数参数
     * @return Result
     */
    public function call($serviceName, $params = array(), $constructParams = array())
    {
        $resultObj = new Result();

        try {
            if (strpos($serviceName, '::') === false) {
                throw new \Exception('method cannot be empty', 9000);
            }
            list($className, $method) = explode('::', $serviceName);
            $class = new \ReflectionClass($className);

            if ($class->getMethod($method)->isStatic()) {
                $resultObj->result = call_user_func_array(array($className, $method), $params);
            } else {
                $instance = $class->newInstanceArgs($constructParams);
                switch (count($params)) {
                    case 0:
                        $resultObj->result = $instance->$method();
                        break;
                    case 1:
                        $resultObj->result = $instance->$method($params[0]);
                        break;
                    case 2:
                        $resultObj->result = $instance->$method($params[0], $params[1]);
                        break;
                    case 3:
                        $resultObj->result = $instance->$method($params[0], $params[1], $params[2]);
                        break;
                    case 4:
                        $resultObj->result = $instance->$method($params[0], $params[1], $params[2], $params[3]);
                        break;
                    case 5:
                        $resultObj->result = $instance->$method($params[0], $params[1], $params[2], $params[3], $params[4]);
                        break;
                    default:
                        $resultObj->result = call_user_func_array(array($instance, $method), $params);
                        break;
                }
            }
        } catch (\Exception $e) {
            $errCode = $e->getCode() == 0 ? 9001 : $e->getCode();
            $resultObj->result = array(
                'code' => $errCode,
                'msg' => $e->getMessage(),
                'data' => '',
            );
        }

        return $resultObj;
    }
}

/**
 * 结果对象
 *
 * @package LaravelPsf
 */
class Result
{
    public $result = array();

    public function getResult()
    {
        return $this->result;
    }
}