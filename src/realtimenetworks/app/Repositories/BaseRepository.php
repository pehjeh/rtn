<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

abstract class BaseRepository
{
    /**
     * model
     *
     * @var Builder mixed
     */
    public $model;

    /*
     * Return Model Class
     */
    abstract function model(): string;

    public function makeModel()
    {
        $m = $this->model();
        $this->model = new $m();

        return $this->model;
    }

    public function resetModel(): void
    {
        $this->makeModel();
    }

    public function find($value, string $specificColumn = 'id', string $operator = '=')
    {
        return $this->model->findOrFail($value);
    }

    public function destroy($id)
    {
        return $this->find($id)->delete();
    }

    public function create($params)
    {
        return $this->makeModel()
            ->create($params);
    }

    public function update($id, $params)
    {
        $object = $this->find($id);
        return $this->makeModel()
            ->create($params);
    }

    public function select($columns)
    {
        $this->model = $this->model->select($columns);
        return $this;
    }

    public function selectRaw($sql)
    {
        $this->model = $this->model->selectRaw($sql);
        return $this;
    }

    public function first()
    {
        return $this->model->first();
    }


    public function limit(int $limit = 25)
    {
        $this->model->limit($limit);

        return $this;
    }

    public function all($columns = ['*'])
    {
        if ($this->model instanceof Builder) {
            $results = $this->model->get($columns);
        } else {
            $results = $this->model->all($columns);
        }

        $this->resetModel();

        return $results;
        // $this->resetScope();

        // return $this->parserResult($results);
    }

    public function where($column, $value, $operator = '=')
    {
        $this->model = $this->model->where($column, $operator, $value);
        return $this;
    }

    public function whereNotNull($column)
    {
        $this->model = $this->model->whereNotNull($column);
        return $this;
    }

    public function groupBy(array|string $column)
    {
        $this->model = $this->model->groupBy($column);
        return $this;
    }

    public function findWhere(array $where, $columns = ['*'])
    {
        $this->applyConditions($where);

        // $model = $this->model->get($columns);
        // $this->resetModel();

        // return $this->parserResult($model);

        return $this->model->get();
    }

    public function with(mixed $with = '')
    {
        $this->model = $this->model->with($with);
        return $this;
    }

    public function whereHas(string $relationship, $callback)
    {
        $this->model = $this->model->whereHas($relationship, $callback);
        return $this;
    }

    public function whereIn(string $column, array $params = [])
    {
        $this->model = $this->model->whereIn($column, $params);
        return $this;
    }


    public function get()
    {
        return $this->model->get();
    }

    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                //smooth input
                $condition = preg_replace('/\s\s+/', ' ', trim($condition));

                //split to get operator, syntax: "DATE >", "DATE =", "DAY <"
                $operator = explode(' ', $condition);
                if (count($operator) > 1) {
                    $condition = $operator[0];
                    $operator = $operator[1];
                } else $operator = null;
                switch (strtoupper($condition)) {
                    case 'IN':
                        if (!is_array($val)) throw new RepositoryException("Input {$val} mus be an array");
                        $this->model = $this->model->whereIn($field, $val);
                        break;
                    case 'NOTIN':
                        if (!is_array($val)) throw new RepositoryException("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotIn($field, $val);
                        break;
                    case 'DATE':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereDate($field, $operator, $val);
                        break;
                    case 'DAY':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereDay($field, $operator, $val);
                        break;
                    case 'MONTH':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereMonth($field, $operator, $val);
                        break;
                    case 'YEAR':
                        if (!$operator) $operator = '=';
                        $this->model = $this->model->whereYear($field, $operator, $val);
                        break;
                    case 'EXISTS':
                        if (!($val instanceof Closure)) throw new RepositoryException("Input {$val} must be closure function");
                        $this->model = $this->model->whereExists($val);
                        break;
                    case 'HAS':
                        if (!($val instanceof Closure)) throw new RepositoryException("Input {$val} must be closure function");
                        $this->model = $this->model->whereHas($field, $val);
                        break;
                    case 'HASMORPH':
                        if (!($val instanceof Closure)) throw new RepositoryException("Input {$val} must be closure function");
                        $this->model = $this->model->whereHasMorph($field, $val);
                        break;
                    case 'DOESNTHAVE':
                        if (!($val instanceof Closure)) throw new RepositoryException("Input {$val} must be closure function");
                        $this->model = $this->model->whereDoesntHave($field, $val);
                        break;
                    case 'DOESNTHAVEMORPH':
                        if (!($val instanceof Closure)) throw new RepositoryException("Input {$val} must be closure function");
                        $this->model = $this->model->whereDoesntHaveMorph($field, $val);
                        break;
                    case 'BETWEEN':
                        if (!is_array($val)) throw new RepositoryException("Input {$val} mus be an array");
                        $this->model = $this->model->whereBetween($field, $val);
                        break;
                    case 'BETWEENCOLUMNS':
                        if (!is_array($val)) throw new RepositoryException("Input {$val} mus be an array");
                        $this->model = $this->model->whereBetweenColumns($field, $val);
                        break;
                    case 'NOTBETWEEN':
                        if (!is_array($val)) throw new RepositoryException("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotBetween($field, $val);
                        break;
                    case 'NOTBETWEENCOLUMNS':
                        if (!is_array($val)) throw new RepositoryException("Input {$val} mus be an array");
                        $this->model = $this->model->whereNotBetweenColumns($field, $val);
                        break;
                    case 'RAW':
                        $this->model = $this->model->whereRaw($val);
                        break;
                    default:
                        $this->model = $this->model->where($field, $condition, $val);
                }
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }


    public function orderBy(string $column, ?string $direction = 'asc'): self
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    public function execute()
    {
        return $this->model->get();
    }

    public function __construct()
    {
        $this->makeModel();
    }
}
