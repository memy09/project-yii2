<?php

use common\models\RegBCurriculum;
use common\models\RegBTerm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'ผลการเรียนเฉลี่ย';
?>
<?php $this->registerCss("
    @media only screen and (min-width : 768px) {
        .search {
            display: flex;
            align-items: center;
        }
    }
        ") ?>
<div id="app">
    <div class="panel">

        <div class="panel-body">
            <h3 class="title-hero">
                <?= $this->title ?>
            </h3>
            <?php $form = ActiveForm::begin() ?>


            <div class="row">
                <div class="search">
                <div class="col-md-2"><?= $form->field($model, 'AcademicYear')->textInput(['v-model' => 'AcademicYear']) ?></div>
                <div class="col-md-2"><?= $form->field($model, 'CurriculumID')->dropDownList(ArrayHelper::map(RegBCurriculum::find()->all(), 'CurriculumID', 'CurriculumName'), ['v-model' => 'CurriculumID']) ?></div>
                <div class="col-md-2"><?= $form->field($model, 'TermID')->dropDownList(ArrayHelper::map(RegBTerm::find()->all(), 'TermID', 'TermName'), ['v-model' => 'TermID']) ?></div>
                <div class="col-md-2"><?= Html::button('แสดงผล', ['class' => 'btn btn-success btn-submit', 'v-on:click' => 'report']) ?></div>
                </div>
            </div>


            <?php ActiveForm::end() ?>
        </div>


        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ระดับ</th>
                <th>0.00-0.99</th>
                <th>1.00-1.49</th>
                <th>1.50-1.99</th>
                <th>2.00-2.49</th>
                <th>2.50-2.99</th>
                <th>3.00-3.49</th>
                <th>3.50-3.99</th>
                <th>4.00</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="data in Results">
                <td>{{ data.ClassName }}</td>
                <td>{{ data.cnt1 }}</td>
                <td>{{ data.cnt2 }}</td>
                <td>{{ data.cnt3 }}</td>
                <td>{{ data.cnt4 }}</td>
                <td>{{ data.cnt5 }}</td>
                <td>{{ data.cnt6 }}</td>
                <td>{{ data.cnt7 }}</td>
                <td>{{ data.cnt8 }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div><!-- app -->

<script>
    loadProgressBar()

    app = new Vue({
        el: "#app",
        data: {
            AcademicYear: "",
            TermID: "",
            CurriculumID: "",
            Results: []
        },
        methods: {
            report: function (event) {
                var vm = this;
                axios.get("<?=Url::to(['/information/report-json/average-grade', true])?>", {
                    params: {
                        AcademicYear: vm.AcademicYear,
                        CurriculumID: vm.CurriculumID,
                        TermID: vm.TermID
                    }
                })
                    .then(function (response) {
                        vm.Results = response.data
                        //console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            }
        }
    })

</script>
