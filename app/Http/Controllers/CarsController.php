<?php

namespace App\Http\Controllers;

use App\Entities\Car;
use App\Http\Requests\ValidatedCarRequest;
use App\Repositories\Contracts\CarRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Repositories\Exceptions\NotFoundException;

class CarsController extends Controller
{
    private $carsRepository;

    public function __construct(CarRepositoryInterface $carsRepository)
    {
        $this->carsRepository = $carsRepository;
    }

    /**
     * Display a cars list.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(): View
    {
        $cars = $this->carsRepository->getAll();
        return view('cars/index', ['cars' => $cars->toArray()]);
    }

    /**
     * Display car info with $id.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $id): View
    {
        $car = $this->carsRepository->getById($id);

        if (is_null($car)) {
            abort(404);
        }

        return view('cars/show', $car->toArray());
    }

    /**
     * Show a form for editing a car with $id.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function edit(int $id): View
    {
        $car = $this->carsRepository->getById($id) ?: abort(404);
        return view('cars/edit', $car->toArray());
    }

    /**
     * Deleting car with $id.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $this->carsRepository->delete($id);
        return redirect()->route('cars-list');
    }

    /**
     * Show a form for creating a new car.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(): View
    {
        return view('cars/create');
    }

    /**
     * Store a new car to storage.
     *
     * @param ValidatedCarRequest $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function store(ValidatedCarRequest $request): View
    {
        $data = $request->only(['model', 'color', 'registration_number', 'year', 'price']);
        $car = new Car($data);
        $this->carsRepository->addItem($car);

        return $this->index();
    }

    /**
     * Update car info with $id.
     *
     * @param int $id
     * @param ValidatedCarRequest $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function update(int $id, ValidatedCarRequest $request): View
    {
        $currentCar = $this->carsRepository->getById($id);
        $car = $currentCar ? $currentCar->toArray() : abort(404);
        foreach ($request->all() as $key => $val) {
            $car[$key] = $val;
        }
        $newCar = new Car($car);
        try {
            $this->carsRepository->update($newCar);
        } catch(NotFoundException $e) {
            abort(404, $e->getMessage());
        }
        return $this->show($id);
    }
}