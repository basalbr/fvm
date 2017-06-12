<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Imposto extends Model {

    use SoftDeletes;

    private static $arr_meses = array(
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    );

   

    protected $rules = ['nome' => 'required', 'vencimento' => 'required|integer', 'antecipa_posterga' => 'required', 'recebe_documento' => 'required'];
    protected $errors;
    protected $niceNames = ['nome' => 'Nome', 'vencimento' => 'Dia do Vencimento', 'antecipa_posterga' => 'Antecipa ou posterga', 'recebe_documento' => 'Receber documentos'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imposto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'vencimento', 'antecipa_posterga', 'recebe_documento'];

    public function validate($data) {
        // make a new validator object
        $v = Validator::make($data, $this->rules);
        $v->setAttributeNames($this->niceNames);
        // check for failure
        if ($v->fails()) {
            // set errors and return false
            $this->errors = $v->errors()->all();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors() {
        return $this->errors;
    }

    public function meses() {
        return $this->hasMany('App\ImpostoMes', 'id_imposto');
    }

    public function instrucoes() {
        return $this->hasMany('App\Instrucao', 'id_imposto', 'id');
    }

    public function informacoes_extras() {
        return $this->hasMany('App\InformacaoExtra', 'id_imposto', 'id');
    }

     public function corrigeData($date, $format) {
        $retDate = new \DateTime($date);
        $weekDay = date('w', strtotime($date));
        if ($this->antecipa_posterga == 'posterga') {
            if ($weekDay == 0) {
                $retDate->add(new \DateInterval('P1D'));
            }
            if ($weekDay == 6) {
                $retDate->add(new \DateInterval('P2D'));
            }
        }
        if ($this->antecipa_posterga == 'antecipa') {
            if ($weekDay == 0) {
                $retDate->sub(new \DateInterval('P2D'));
            }
            if ($weekDay == 6) {
                $retDate->sub(new \DateInterval('P1D'));
            }
        }
        return $retDate->format($format);
    }
    
}
