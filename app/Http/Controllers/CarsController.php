<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.07.17
 * Time: 19:25
 */

namespace App\Http\Controllers;


use App\Entities\Car,
    App\Http\Requests\ValidatedCarRequest,
    App\Repositories\Contracts\CarRepositoryInterface,
    Illuminate\Http\RedirectResponse,
    Illuminate\Support\Facades\Redirect,
    Illuminate\View\View;

class CarsController extends Controller
{
    private $carsRepository;

    /**
     * CarsController constructor.
     * @param CarRepositoryInterface $carsRepository
     */
    public function __construct(CarRepositoryInterface $carsRepository)
    {
        $this->carsRepository = $carsRepository;
    }

    /**
     * Display a cars list.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cars = $this->carsRepository->getAll();
        return view('cars/index', ['cars' => $cars->toArray()]);
    }

    /**
     * Display car info with $id.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id) : View
    {
        $car = $this->carsRepository->getById($id);
        if (is_null($car)) {
            abort(404);
        }

        return view('cars/show', $car->toArray());
    }

    public function edit(int $id)
    {
        $car = $this->carsRepository->getById($id) ?: abort(404);
        $car = $car->toArray();
    }

    /**
     * Deleting car with $id.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id) : RedirectResponse
    {
        $this->carsRepository->delete($id);
        return redirect()->route('cars-list');
    }

    /**
     * Show a form for creating a new car.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() : View
    {
        return view('cars/create');
    }

    /**
     * @param ValidatedCarRequest $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function store(ValidatedCarRequest $request) : View
    {
        $data = $request->only(['model', 'color', 'registration_number', 'year', 'price']);
        $car = new Car($data);
        $this->carsRepository->addItem($car);

        return $this->index();
    }
}