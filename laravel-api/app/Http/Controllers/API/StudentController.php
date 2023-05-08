<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /*
        @Author : Nantenaina
        Get students list
     */
    public function index()
    {
        $students = Student::all();
        $results = count($students) > 0 ? $students : "Aucun enregistrement";
        return response()->json($students, 200);
    }

    /*
        Get one student
     */
    public function findOne($id)
    {
        $student = Student::find($id);
        $result = null;
        $status = 500;
        if ($student) {
            $result = $student;
            $status = 200;
        } else {
            $result = "Aucun étudiant correspondant à cet identifiant";
            $status = 404;
        }
        return response()->json($result, $status);
    }

    /*
        Add one student
     */
    public function save(Request $request, Student $student)
    {

        $body = $request->all();

        $validator = Validator::make(
            $body,
            [
                "name" => 'required|string|max:20',
                "course" => 'required|string|max:20',
                "email" => 'required|email|max:30',
                "phone" => 'required'
            ],
            [
                "name.required" => 'Le nom est obligatoire',
                "name.string" => 'Le nom doit être une chaine de caractères',
                "name.max" => 'Le nom est trop long',
                "course.required" => 'Le cours est obligatoire',
                "course.string" => 'Le cours doit être une chaine de caractères',
                "course.max" => 'Le cours est trop long',
                "email.required" => 'L\'email est obligatoire',
                "email.email" => 'L\'email n\'est pas valide',
                "email.max" => 'L\'email est trop long',
                "phone.required" => 'Le téléphone est obligatoire',

            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => false,
                    "message" => $validator->messages()
                ],
                422
            );
        } else {

            $student->name = $request->name;
            $student->course = $request->course;
            $student->email = $request->email;
    		$student->phone = $request->phone;

            if ($request->hasFile('image')) {
    			$file = $request->file('image');
    			$extension = $file->getClientOriginalExtension();
    			$fileName = time() . '.' . $extension;
    			$file->move('../../vue-project/public/uploads/', $fileName);
    			$student->image = $fileName;
    		}else{
                $student->image = "img_avatar.png";
            }

            $result = $student->save();

            if ($result) {
                return response()->json(
                    [
                        "status" => true,
                        "message" => "Etudiant enregistré avec succès !",
                        "result" => $result
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Quelque chose ne va pas !",
                        "result" => $result
                    ],
                    500
                );
            }
        }
    }

    /*
        Update one student
     */
    public function update(Request $request, int $id)
    {

        $body = $request->all();

        $validator = Validator::make(
            $body,
            [
                "name" => 'required|string|max:20',
                "course" => 'required|string|max:20',
                "email" => 'required|email|max:30',
                "phone" => 'required'
            ],
            [
                "name.required" => 'Le nom est obligatoire',
                "name.string" => 'Le nom doit être une chaine de caractères',
                "name.max" => 'Le nom est trop long',
                "course.required" => 'Le cours est obligatoire',
                "course.string" => 'Le cours doit être une chaine de caractères',
                "course.max" => 'Le cours est trop long',
                "email.required" => 'L\'email est obligatoire',
                "email.email" => 'L\'email n\'est pas valide',
                "email.max" => 'L\'email est trop long',
                "phone.required" => 'Le téléphone est obligatoire',

            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => false,
                    "message" => $validator->messages()
                ],
                422
            );
        } else {

            $student = Student::find($id);

            if ($student) {
                $student->name = $request->name;
                $student->course = $request->course;
                $student->email = $request->email;
                $student->phone = $request->phone;

                if ($request->hasFile('image')) {

                    if($student->image != "img_avatar.png"){
                        $path = '../../vue-project/public/uploads/'. $student->image;
                        if (\File::exists($path)) {
                            \File::delete($path);
                        }
                    }

                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = time() . '.' . $extension;
                    $file->move('../../vue-project/public/uploads/', $fileName);
                    $student->image = $fileName;

                }

                $student->update();

                return response()->json(
                    [
                        "status" => true,
                        "students" => $body,
                        "message" => "Etudiant modifié avec succès !"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Aucun étudiant correspondant à cet identifiant !"
                    ],
                    404
                );
            }
        }
    }

    /*
        Delete one student
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        $result = null;
        $status = 500;
        if ($student) {

            if($student->image != "img_avatar.png"){
                $path = '../../vue-project/public/uploads/'. $student->image;
                if (\File::exists($path)) {
                    \File::delete($path);
                }
            }

            $student->delete();
            
            $result = "Etudiant supprimé avec succès !";

            $status = 200;

        } else {
            $result = "Aucun étudiant correspondant à cet identifiant";
            $status = 404;
        }
        return response()->json(["student" => $student, "message" => $result, "status" => $status], $status);
    }
}