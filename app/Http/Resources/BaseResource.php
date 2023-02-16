<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class BaseResource extends JsonResource
{

    public $statusCode = 200;
    public $status = true;
    public $message = 'Success!';

    /**
     * BaseResource constructor.
     *
     * @param $resource
     */
    public function __construct($resource = null)
    {
        if (is_null($resource)) {
            $resource = collect();
        }

        if (is_array($resource)) {
            $resource = collect($resource);
        }
        parent::__construct($resource);
    }

    public function additionalMerge(array $data): JsonResource
    {
        $this->additional = array_merge($this->additional ?: [], $data);

        return parent::additional($data); // TODO: Change the autogenerated stub
    }

    /**
     * @param Request $request
     * @param JsonResponse $response
     */
    public function withResponse($request, $response)
    {
        $data = $response->getData();
        $response->setStatusCode($this->statusCode);
        $response->setData(
            array_merge_recursive(
                [
                    'status' => $this->status,
                    'message' => $this->message,
                    'status_code' => $this->statusCode,
                ],
                (array)$data
            )
        );
    }

    /**
     * @param  $statusCode
     * @return \App\Http\Resources\BaseResource
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        if ($this->statusCode >= 400) {
            $this->message = 'Failure!!';
        }

        return $this;
    }

    /**
     * @param  $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param  $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public static function collection($resource)
    {
        $res = new AnonymousResourceCollection($resource, get_called_class());
        return response()->json([
            'status' => true,
            'message' => 'Success!',
            'status_code' => 200,
            'data' => $res,
        ]);
    }

    /**
     * @param Model|mixed $resource
     * @return BaseResource|AnonymousResourceCollection
     * @throws Exception
     */
    public static function paginable($resource)
    {
        if ($resource instanceof LengthAwarePaginator) {
            throw new \Exception("Don't call ->paginable() on your payload if you want to use this function");
        }
        $request = resolve(Request::class);
        $paginate = filter_var($request->get('paginate', true), FILTER_VALIDATE_BOOLEAN);
        $page = $request->get('page', 1);
        if ($paginate) {
            $perPage = $request->get('per_page',15);

            if (method_exists($resource, 'paginate')) {
                return self::collection($resource->paginate($perPage));
            } else {
                $resourceAsCollection = $resource instanceof Collection ? $resource : collect($resource);
                $paginator = new LengthAwarePaginator(
                    $resourceAsCollection->forPage($page, $perPage),
                    $resourceAsCollection->count(),
                    $perPage,
                    $page
                );
                return self::collection($paginator);
            }
        }
        if (method_exists($resource, 'get')) {
            return self::create($resource->get());
        }

        return self::create($resource);
    }

    public static function create($resource)
    {
        return new static($resource);
    }

    public static function errors(
        $errors = [],
        $message = null,
        $statusCode = 500,
        $status = false,
        $errorString = 'Unknown error !'
    )
    {
        if (is_null($message)) {
            $message = 'An error has occurred!';
        }
        $instance = new static;

        $errorMeta = [
            'errorMessage' => $message,
            'errorString' => $errorString,
        ];
        $errorsArray = $errors ?? $errorMeta;

        $instance->setStatusCode($statusCode);
        $instance->setStatus($status);

        $instance->additionalMerge(
            [
                'errors' => $errorsArray,
            ]
        );

        return $instance;
    }

    /**
     * @param \Exception $e
     * @return JsonResponse
     */
    public static function exception($e): JsonResponse
    {
        Log::error($e->getMessage(), ['exception' => $e]);
        return static::return($e->getMessage(), 500);
    }

    public static function ok($message = 'Success!', $statusCode = 200)
    {
        $instance = new static;
        $instance->message = $message;
        $instance->statusCode = $statusCode;

        return $instance;
    }

    public static function validationErrors($validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json(
                [
                    'status' => false,
                    'message' => 'Validation Error',
                    'data' => $validator->errors(),
                ],
                422
            )
        );
    }

    public static function returnMsg($message = 'error!', $statusCode = 402, $status = false)
    {
        return response()->json(
            [
                'status' => $status,
                'message' => $message,
                'data' => [],
            ],
            $statusCode
        );
    }

}

