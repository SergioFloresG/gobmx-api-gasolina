<?php


namespace App\Http\Controllers;


use App\Repositories\GobmxGasStationsRepository;
use App\Repositories\PostalCodesRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class GobmxGasStationController extends Controller
{

    /**
     * @var GobmxGasStationsRepository
     */
    private $repository;
    /**
     * @var PostalCodesRepository
     */
    private $codesRepository;

    public function __construct(
        GobmxGasStationsRepository $repository,
        PostalCodesRepository $codesRepository
    )
    {
        $this->repository = $repository;
        $this->codesRepository = $codesRepository;
    }

    public function indexByPostalCode(Request $request, $state, $town)
    {
        $thestate = $this->codesRepository->getState($state);
        $thentown = $this->codesRepository->getTownship($state, $town);

        if (null === $thestate || null === $thentown) {
            throw new ModelNotFoundException('State or township not found');
        }

        $postalcodes = $this->codesRepository->obtainPostalCodesOfTownship($state,$town);
        $resul = $this->repository->getByPostalCodes($postalcodes->toArray());

        return response()->json($resul);
    }

}