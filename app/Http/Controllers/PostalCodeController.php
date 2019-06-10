<?php
namespace App\Http\Controllers;

use App\Http\Resources\PostalCodeState;
use App\Http\Resources\PostalCodeTown;
use App\Repositories\PostalCodesRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PostalCodeController extends Controller
{

    /**
     * @var PostalCodesRepository
     */
    private $repository;

    public function __construct(PostalCodesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $state, $town)
    {
        $state = $this->repository->getState($state);
        if (null === $state) {
            throw new ModelNotFoundException('State not found');
        }

        $town = $this->repository->getTownship($state->state_key, $town);
        if (null === $town) {
            throw new ModelNotFoundException('Township not found');
        }

        $postal_codes = $this->repository->obtainPostalCodesOfTownship($state->state_key, $town->town_key);
        $result = [
            'state' => new PostalCodeState($state),
            'town'  => new PostalCodeTown($town),
            'data'  => $postal_codes
        ];

        return response()->json($result);
    }

    /**
     * Display a listing of states in postal codes catalog.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function indexStates()
    {
        $states = $this->repository->obtainStates();

        return PostalCodeState::collection($states);
    }

    /**
     * Display a listing of townships in state, in postal codes catalog.
     *
     * @param integer $state
     *
     * @return PostalCodeState
     */
    public function indexTowns($state)
    {
        $state = $this->repository->getState($state);
        if (null === $state) {
            throw new ModelNotFoundException('State not found');
        }
        $towns = $this->repository->obtainTownshipOfState($state->state_key);

        $data = [
            'state' => new PostalCodeState($state),
            'data'  => PostalCodeTown::collection($towns)
        ];

        return response()->json($data);
    }


}
