<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//追記。ContactFormクラスを使えるようにuse
use App\Models\ContactForm;
//ファサードによってクエリビルダで書けるようにする
use Illuminate\Support\Facades\DB;
//ファっとコントローラーにならないようにした
use App\Services\CheckFormData;
//メアドが重複しないようにする
use App\Http\Requests\StoreContactForm;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        //$contacts=ContactForm::all();
        //Eloquent　ORマッパー
        //クエリビルダ
        // $contacts = DB::table('contact_forms')
        //     ->select('id', 'your_name', 'title', 'created_at')
        //     ->orderBy('created_at', 'asc')
        //     //->get();
        //     ->paginate(20);

        //検索フォーム用
        $query = DB::table('contact_forms');

        //where文
        if($search!==null){
            //全宅スペースを半角に
            $search_split=mb_convert_kana($search,'s');
            //空白で区切る
            $search_split2=preg_split('/[\s]+/',$search_split,-1,PREG_SPLIT_NO_EMPTY);
            //単語をループで回す
            foreach($search_split2 as $value){
                $query->where('your_name', 'like', '%'. $value. '%');
            }
        };

        $query->select('id', 'your_name', 'title', 'created_at');
        $query->orderBy('created_at', 'asc');
        $contacts = $query->paginate(20);

        return view('contact.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactForm $request)
    {
        //前までは$_POST['name']みたいに書いて変数を持ってきていたけどLaravelの場合はRequest型の変数として扱うことができる
        //ちなみにRequestクラスはDI(依存性の注入)によるインスタンス化されたクラス

        //ContactFormクラスをインスタンス化
        $contact = new ContactForm;
        $contact->your_name = $request->input('your_name');
        $contact->title = $request->input('title');
        $contact->email = $request->input('email');
        $contact->url = $request->input('url');
        $contact->gender = $request->input('gender');
        $contact->age = $request->input('age');
        $contact->contact = $request->input('contact');

        //上で代入した値たちを保存する
        $contact->save();
        //indexページに飛ばすheaderみたいな感じかな
        return redirect('contact/index');

        //ちゃんと値が取れているか確認用
        //dd($your_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //dd($id);
        $contact = ContactForm::find($id);

        //ファットコントローラーにならないようにする
        $gender = CheckFormData::checkGender($contact);
        $age = CheckFormData::checkAge($contact);

        return view('contact.show', compact('contact', 'gender', 'age'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $contact = ContactForm::find($id);

        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $contact = ContactForm::find($id);
        $contact->your_name = $request->input('your_name');
        $contact->title = $request->input('title');
        $contact->email = $request->input('email');
        $contact->url = $request->input('url');
        $contact->gender = $request->input('gender');
        $contact->age = $request->input('age');
        $contact->contact = $request->input('contact');

        //上で代入した値たちを保存する
        $contact->save();
        //indexページに飛ばすheaderみたいな感じかな
        return redirect('contact/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $contact = ContactForm::find($id);
        $contact->delete();

        return redirect('contact/index');
    }
}
