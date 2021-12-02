<?php

namespace App\Presentation\Http\Controllers\Api\Media;

use App\Help\Domain\MediaParameter;
use App\Http\Controllers\Controller;
use App\Presentation\Http\Controllers\Api\ApiBaseController;
use App\Service\Contracts\Media\IMediaService;
use App\Service\Contracts\Media\Request\CreateMediaRequest;
use App\Service\Contracts\Media\Request\FileUploadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MediaController extends ApiBaseController
{
    private IMediaService $_mediaService;

    public function __construct(IMediaService $mediaService)
    {
        $this->_mediaService = $mediaService;
    }

    /**
     * @OA\Post(
     *     path="/media/file-upload",
     *     operationId="actionFileUploadMedia",
     *     tags={"Media"},
     *     description="File upload media",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="collection",
     *                      description="Collection property",
     *                      type="string",
     *                      enum={"PUBLIC", "PROFILE", "ORGANIZATION"},
     *                      default="PUBLIC"
     *                  ),
     *                  @OA\Property(
     *                      property="file",
     *                      description="File property",
     *                      type="file",
     *                      format="file",
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              allOf={
     *                  @OA\Schema(ref="#/components/schemas/GetBasicSuccessJson"),
     *                  @OA\Schema(
     *                      @OA\Property(
     *                          property="data",
     *                          description="Data property",
     *                          type="object"
     *                      )
     *                  )
     *              }
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionFileUpload(Request $request)
    {
        $collection = $request->input('collection');

        $fileUploadRequest = new FileUploadRequest();
        $fileUploadRequest->file = $request->file('file');

        switch ($collection) {
            case "PROFILE":
                $fileUploadResponse = $this->_mediaService->fileUpload($fileUploadRequest,
                    MediaParameter::AVATAR(),
                    $collection);
                break;

            case "ORGANIZATION":
                $fileUploadResponse = $this->_mediaService->fileUpload($fileUploadRequest,
                    MediaParameter::LOGO(),
                    $collection);
                break;

            case "PUBLIC":
            default:
                $fileUploadResponse = $this->_mediaService->fileUpload($fileUploadRequest,
                    MediaParameter::ALL(),
                    $collection);
                break;
        }

        if ($fileUploadResponse->isError()) {
            return $this->getErrorJson($fileUploadResponse);
        }

        $fileUploaded = $fileUploadResponse->dto;

        $createMediaRequest = new CreateMediaRequest();

        $createMediaRequest->user_id = $fileUploaded->user_id;
        $createMediaRequest->collection = $fileUploaded->collection;
        $createMediaRequest->original_name = $fileUploaded->original_name;
        $createMediaRequest->generate_name = $fileUploaded->generate_name;
        $createMediaRequest->extension = $fileUploaded->extension;
        $createMediaRequest->mime_type = $fileUploaded->mime_type;
        $createMediaRequest->path = $fileUploaded->path;
        $createMediaRequest->url = $fileUploaded->url;
        $createMediaRequest->width = $fileUploaded->width;
        $createMediaRequest->height = $fileUploaded->height;
        $createMediaRequest->size = $fileUploaded->size;

        $this->setRequestAuthor($createMediaRequest);

        $createMediaResponse = $this->_mediaService->createMedia($createMediaRequest);

        if ($createMediaResponse->isError()) {
            return $this->getErrorJson($createMediaResponse);
        }

        return $this->getBasicSuccessWithDataJson($createMediaResponse, $createMediaResponse->dto);
    }

    /**
     * @OA\Post(
     *     path="/media/file-uploads",
     *     operationId="actionFilesUploadMedia",
     *     tags={"Media"},
     *     description="Files upload media",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="collection",
     *                      description="Collection property",
     *                      type="string",
     *                      enum={"PUBLIC", "PROFILE", "ORGANIZATION"},
     *                      default="PUBLIC"
     *                  ),
     *                  @OA\Property(
     *                      property="medias",
     *                      description="File property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="file",
     *                          format="file"
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicSuccessJson")
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionFileUploads(Request $request)
    {
        $collection = $request->input('collection');

        $medias = $request->input('medias');

        $fileUploadRequests = new Collection();

        foreach ($medias as $media) {
            $fileUploadRequest = new FileUploadRequest();

            if (is_array($media)) {
                $media = (object)$media;
            }

            $fileUploadRequest->file = (property_exists($media, 'file')) ? $media->file : null;

            $fileUploadRequests->push($fileUploadRequest);
        }

        switch ($collection) {
            case "PROFILE":
            case "ORGANIZATION":
                $fileUploadResponses = $this->_mediaService->fileUploads($fileUploadRequests,
                    MediaParameter::AVATAR(),
                    $collection);
                break;

            case "PUBLIC":
            default:
                $fileUploadResponses = $this->_mediaService->fileUploads($fileUploadRequests,
                    MediaParameter::ALL(),
                    $collection);
                break;
        }

        if ($fileUploadResponses->isError()) {
            return $this->getErrorJson($fileUploadResponses);
        }

        $filesUploaded = $fileUploadResponses->dtoCollection();

        $filesUploaded->each(function($fileUploaded, $key) {
            $createMediaRequest = new CreateMediaRequest();

            $createMediaRequest->user_id = $fileUploaded->user_id;
            $createMediaRequest->collection = $fileUploaded->collection;
            $createMediaRequest->original_name = $fileUploaded->original_name;
            $createMediaRequest->generate_name = $fileUploaded->generate_name;
            $createMediaRequest->extension = $fileUploaded->extension;
            $createMediaRequest->mime_type = $fileUploaded->mime_type;
            $createMediaRequest->path = $fileUploaded->path;
            $createMediaRequest->url = $fileUploaded->url;
            $createMediaRequest->width = $fileUploaded->width;
            $createMediaRequest->height = $fileUploaded->height;
            $createMediaRequest->size = $fileUploaded->size;

            $this->setRequestAuthor($createMediaRequest);

            $this->_mediaService->createMedia($createMediaRequest);
        });

        if ($fileUploadResponses->isError()) {
            return $this->getErrorJson($fileUploadResponses);
        }

        return $this->getBasicSuccessWithDataJson($fileUploadResponses, $fileUploadResponses->dtoCollection());
    }

    /**
     * @OA\Get(
     *     path="/medias",
     *     operationId="actionGetMedias",
     *     tags={"Media"},
     *     description="Get medias",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/MediaEloquent")
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionGetMedias()
    {
        $getMediasResponse = $this->_mediaService->getMedias();

        if ($getMediasResponse->isError()) {
            return $this->getErrorJson($getMediasResponse);
        }

        return $this->getDataJsonResponse($getMediasResponse->dtoCollection());
    }

    public function actionGetListSearchMedias(Request $request)
    {
        $userId = $request->input('user_id');
        $roleId = $request->input('role_id');
        $collection = $request->input('collection');

        return $this->getListSearchJson($request,
            function(GenericListSearchResponse $entities) {
                return $entities->dtoCollection();
            }, [$this->_mediaService, 'getMediasListSearch'],
            ['userId' => $userId, 'roleId' => $roleId, 'collection' => $collection]);
    }

    /**
     * @OA\Get(
     *     path="/media/{id}",
     *     operationId="actionShowMedia",
     *     tags={"Media"},
     *     description="Show media",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              @OA\Schema(ref="#/components/schemas/MediaEloquent")
     *          )
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionShowMedia(string $id)
    {
        $getShowMediaResponse = $this->_mediaService->showMedia($id);

        if ($getShowMediaResponse->isError()) {
            return $this->getErrorJson($getShowMediaResponse);
        }

        return $this->getDataJsonResponse($getShowMediaResponse->dto);
    }

    /**
     * @OA\Delete(
     *     path="/media/{id}",
     *     operationId="actionDestroyMedia",
     *     tags={"Media"},
     *     description="Destroy media",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDestroyMedia(string $id)
    {
        $destroyMediaResponse = $this->_mediaService->destroyMedia($id);

        if ($destroyMediaResponse->isError()) {
            return $this->getErrorJson($destroyMediaResponse);
        }

        return $this->getBasicSuccessWithStringJson($destroyMediaResponse, "Media deleted: " . $destroyMediaResponse->result);
    }

    /**
     * @OA\Delete(
     *     path="/medias",
     *     operationId="actionDestroyMedias",
     *     tags={"Media"},
     *     description="Destroy medias",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="ids",
     *                      description="Ids property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="string"
     *                      )
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Success"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorJson")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/GenericUnauthenticatedJsonResponse")
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error",
     *          @OA\JsonContent(ref="#/components/schemas/GetBasicErrorWithStringJson")
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionDestroyMedias(Request $request)
    {
        $ids = $request->input('ids');

        $destroyMediaResponse = $this->_mediaService->destroyMedias($ids);

        if ($destroyMediaResponse->isError()) {
            return $this->getErrorJson($destroyMediaResponse);
        }

        return $this->getBasicSuccessJson($destroyMediaResponse);
    }
}
