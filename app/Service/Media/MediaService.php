<?php


namespace App\Service\Media;


use App\Core\Domain\Contracts\IUnitOfWorkFactory;
use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Core\Service\Response\StringResponse;
use App\Domain\Contracts\Media\IMediaRepository;
use App\Help\Domain\MediaParameter;
use App\Service\BaseService;
use App\Service\Contracts\Media\IMediaService;
use App\Service\Contracts\Media\ListSearchRequest;
use App\Service\Contracts\Media\PageSearchRequest;
use App\Service\Contracts\Media\Request\CreateMediaRequest;
use App\Service\Contracts\Media\Request\FileUploadRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class MediaService extends BaseService implements IMediaService
{
    private IUnitOfWorkFactory $_unitOfWorkFactory;

    private IMediaRepository $_mediaRepository;

    public function __construct(IUnitOfWorkFactory $unitOfWorkFactory,
                                IMediaRepository $mediaRepository)
    {
        $this->_unitOfWorkFactory = $unitOfWorkFactory;
        $this->_mediaRepository = $mediaRepository;

    }

    public function fileUpload(FileUploadRequest $request, MediaParameter $mediaParameter, string $collection): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $mediaParameter = json_decode($mediaParameter);

            //Validation
            $rules = [
                'file' => $mediaParameter->rules
            ];

            $brokenRules = Validator::make((array)$request, $rules);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            //Upload file
            $path = str_replace('//', '/', $mediaParameter->path);
            $url = str_replace('//', '/', $mediaParameter->url);

            if (!file_exists($path . '/thumb/')) {
                mkdir($path . '/thumb/', 0777, true);
            }

            $extension = $request->file->getClientOriginalExtension();
            $mimeType = $request->file->getMimeType();
            $size = $request->file->getSize();
            $width = null;
            $height = null;

            $originalName = $request->file->getClientOriginalName();
            $generateName = time() . '_' . uniqid();

            if (substr($mimeType, 0, 5) == 'image') {
                $image = Image::make($request->file->path());

                $width = $image->width();
                $height = $image->height();

                if (!file_exists($path)) {
                    mkdir($path, 666);
                    mkdir($path . '/thumb/', 666);
                }

                $image->resize($mediaParameter->width, $mediaParameter->height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path . '/thumb/' . $generateName . '.' . $extension);

                $request->file->move($path, $generateName . '.' . $extension);
            } else {
                $request->file->move($path, $generateName . '.' . $extension);
            }

            $fileUploadResult = (object) [
                "user_id" => Auth::user()->id,
                "collection" => $collection,
                "original_name" => $originalName,
                "generate_name" => $generateName . '.' . $extension,
                "extension" => $extension,
                "mime_type" => $mimeType,
                "path" => $path,
                "url" => $url,
                "width" => $width,
                "height" => $height,
                "size" => $size
            ];

            $response->dto = $fileUploadResult;
            $response->addInfoMessageResponse('File has uploaded');

        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function fileUploads(Collection $requests, MediaParameter $mediaParameter, string $collection): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $mediaParameter = json_decode($mediaParameter);

            $requests->each(function($request, $key) use($response, $mediaParameter, $collection) {
                //Validation
                $rules = [
                    'file' => $mediaParameter->rules
                ];

                $brokenRules = Validator::make((array)$request, $rules);

                if ($brokenRules->fails()) {
                    foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                        foreach ($value as $message) {
                            $response->addErrorMessageResponse($message);
                        }
                    }

                    return $response;
                }

                //Upload file
                $path = str_replace('//', '/', $mediaParameter->path);
                $url = str_replace('//', '/', $mediaParameter->url);

                if (!file_exists($path . '/thumb/')) {
                    mkdir($path . '/thumb/', 0777, true);
                }

                $extension = $request->file->getClientOriginalExtension();
                $mimeType = $request->file->getMimeType();
                $size = $request->file->getSize();
                $width = null;
                $height = null;

                $originalName = $request->file->getClientOriginalName();
                $generateName = time() . '_' . uniqid();

                if (substr($mimeType, 0, 5) == 'image') {
                    $image = Image::make($request->file->path());

                    $width = $image->width();
                    $height = $image->height();

                    $image->resize($mediaParameter->width, $mediaParameter->height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path . '/thumb/' . $generateName . '.' . $extension);

                    $request->file->move($path, $generateName . '.' . $extension);
                } else {
                    $request->file->move($path, $generateName . '.' . $extension);
                }

                $fileUploadResult = (object) [
                    "user_id" => Auth::user()->id,
                    "collection" => $collection,
                    "original_name" => $originalName,
                    "generate_name" => $generateName . '.' . $extension,
                    "extension" => $extension,
                    "mime_type" => $mimeType,
                    "path" => $path,
                    "url" => $url,
                    "width" => $width,
                    "height" => $height,
                    "size" => $size
                ];

                $response->dtoCollection()->push($fileUploadResult);
            });

            $response->addInfoMessageResponse('Files has uploaded');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function getMedias(): GenericCollectionResponse
    {
        return $this->search(
            [$this->_mediaRepository, 'allWithChunk']
        );
    }

    public function getMediasListSearch(ListSearchRequest $request): GenericListSearchResponse
    {
        return $this->listSearch(
            [$this->_mediaRepository, 'findMediasListSearch'],
            $request
        );
    }

    public function getMediasPageSearch(PageSearchRequest $request): GenericPageSearchResponse
    {
        return $this->pageSearch(
            [$this->_mediaRepository, 'findMediasPageSearch'],
            $request
        );
    }

    public function showMedia(string $id): GenericObjectResponse
    {
        return $this->read(
            [$this->_mediaRepository, 'findMediaById'],
            [$id]
        );
    }

    public function createMedia(CreateMediaRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            $media = $this->_mediaRepository->newInstance([
                "user_id" => $request->user_id,
                "collection" => $request->collection,
                "original_name" => $request->original_name,
                "generate_name" => $request->generate_name,
                "extension" => $request->extension,
                "mime_type" => $request->mime_type,
                "path" => $request->path,
                "url" => $request->url,
                "width" => $request->width,
                "height" => $request->height,
                "size" => $request->size
            ]);

            $this->setAuditableInformationFromRequest($media, $request);

            $rules = [
                'user_id' => 'required|integer',
                'collection' => 'required|string|max:255',
                'original_name' => 'required|string|max:255',
                'generate_name' => 'required|string|max:255',
                'extension' => 'required|string',
                'path' => 'required|string',
                'url' => 'required|string',
                'width' => 'integer|nullable',
                'height' => 'integer|nullable',
                'size' => 'required|integer',
            ];

            $brokenRules = $media->validate($rules, $request);

            if ($brokenRules->fails()) {
                foreach ($brokenRules->errors()->getMessages() as $key => $value) {
                    foreach ($value as $message) {
                        $response->addErrorMessageResponse($message);
                    }
                }

                return $response;
            }

            $mediaResult = $unitOfWork->markNewAndSaveChange($this->_mediaRepository, $media);

            $response->dto = $mediaResult;
            $response->addInfoMessageResponse('Media created');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyMedia(string $id): StringResponse
    {
        $response = new StringResponse();

        try {
            $media = $this->_mediaRepository->findMediaById($id);

            if ($media) {
                $unitOfWork = $this->_unitOfWorkFactory->create();

                $mediaResult = $unitOfWork->markRemoveAndSaveChange($this->_mediaRepository, $media);

                $response->result = $mediaResult;

                return $response;
            }

            if (!file_exists($media->path . '/thumb/' . $media->generate_name)) {
                File::delete($media->path . '/' . $media->generate_name);
                File::delete($media->path . '/thumb/' . $media->generate_name);
            }

            $response->addErrorMessageResponse('Media not found');
            $response->setStatus(404);
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }

    public function destroyMedias(array $ids): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $unitOfWork = $this->_unitOfWorkFactory->create();

            foreach ($ids as $id) {
                $media = $this->_mediaRepository->findMediaById($id);

                if ($media) {
                    $unitOfWork->markRemove($this->_mediaRepository, $media);
                }

                if (!file_exists($media->path . '/thumb/' . $media->generate_name)) {
                    File::delete($media->path . '/' . $media->generate_name);
                    File::delete($media->path . '/thumb/' . $media->generate_name);
                }
            }

            $unitOfWork->commit();
            $response->addInfoMessageResponse('Medias deleted');
        } catch (\Exception $ex) {
            $response->addErrorMessageResponse($ex->getMessage());
            $response->setStatus($ex->getCode());
        }

        return $response;
    }
}
