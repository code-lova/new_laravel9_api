<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter {
    protected $safeparam = [];

    protected $columnMap = [];

    protected $operatorMap = [];


    public function transform(Request $request){

        $eloQuery = [];

        foreach($this->safeparam as $param => $operators){
            $query = $request->query($param);

            if(!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach($operators as $operator){
                //If this operator is allowed for this field
                if(isset($query[$operator])){
                    //Lets add an element to our eloquery which is innitially empty.
                    //need to be in the format of an array
                    //where the first element is the column
                    //follwoed by the actual operator
                    //Then the value
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}
