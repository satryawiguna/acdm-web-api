<?php


namespace App\Service\Contracts\Media;


use App\Core\Service\Response\BasicResponse;
use App\Core\Service\Response\GenericCollectionResponse;
use App\Core\Service\Response\GenericListSearchResponse;
use App\Core\Service\Response\GenericObjectResponse;
use App\Core\Service\Response\GenericPageSearchResponse;
use App\Core\Service\Response\StringResponse;
use App\Help\Domain\MediaParameter;
use App\Service\Contracts\Media\Request\CreateMediaRequest;
use App\Service\Contracts\Media\Request\FileUploadRequest;
use Illuminate\Support\Collection;

interface IMediaService
{
    public function fileUpload(FileUploadRequest $request,
                               MediaParameter $mediaParameter,
                               string $collection): GenericObjectResponse;

    public function fileUploads(Collection $requests,
                                MediaParameter $mediaParameter,
                                string $collection): GenericCollectionResponse;

    public function getMedias(): GenericCollectionResponse;

    public function getMediasListSearch(ListSearchRequest $request): GenericListSearchResponse;

    public function getMediasPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    public function showMedia(string $id): GenericObjectResponse;

    public function createMedia(CreateMediaRequest $request): GenericObjectResponse;

    public function destroyMedia(string $id): StringResponse;

    public function destroyMedias(array $ids): BasicResponse;
}
