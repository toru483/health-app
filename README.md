🏥 MediSync (Health-Log App)
複数医療機関の処方を一括管理する、患者主体の服薬アドヒアランス向上プラットフォーム

📋 プロジェクト概要
複数の病院・診療科を跨いで処方される薬剤情報を一元管理し、「飲み忘れ」や「情報の分断」を防ぐためのWebアプリケーションです。
さらに、患者のQOL向上を目的とし、服薬管理だけでなく「体重・血圧・血糖値」を一括して記録・管理できるバイタルログ機能とのクロスアプリケーション連携を備えています。

🛠 技術スタック
Backend: PHP 8.5 / Laravel 13.4

Frontend: Tailwind CSS / Blade Templates

Database: MySQL 8.0 (HeidiSQL for GUI)

Infrastructure: Docker (Laravel Sail) / Ubuntu (WSL2)

Tooling: Doctrine DBAL (DBスキーマ変更用)

🏗 システム設計 (System Architecture)
1. データ構造
医療情報・体調記録の整合性を担保するため、以下のリレーションを採用しています。

Hospitals (病院) └── Departments (診療科) └── Prescriptions (処方箋) └── Medicines (薬剤) └── TakingLogs (服用履歴：秒単位記録)

Vitals (バイタルログ：体重、最高/最低血圧、血糖値の一括管理テーブル)

2. コンポーネント指向を意識した2カラムUI
日常のメイン行動である「服用・確認（タイムライン）」と、管理機能である「マスタ登録・変更・削除（CRUD）」の導線を分離。認知負荷を最小限に抑えるプロ仕様の2カラムレイアウトを採用。

🚀 開発ログ & 技術的課題へのアプローチ
1. 医療データの正確性担保（時分秒のデータ消失バグの解決）
課題: 保存された服用履歴（TakingLogs）の時刻がすべて 00:00 に丸められてしまい、正確な服薬時間が記録できない。

解決: 原因がデータベースの DATE 型にあると特定。doctrine/dbal パッケージを導入し、既存データを保護しつつカラム型を DATETIME（日時）型へ安全に変更するマイグレーションを計画・実行。これにより「秒単位の正確性」を担保した。

2. クロスアプリケーション連携（服薬 ⇄ 体調管理の一括登録）
課題: 将来的なマイクロサービス化（アプリ分離）を見据えつつ、ユーザーが迷わないシームレスな画面遷移とデータ保存を実現する必要性。

解決: 服薬（青）と体調管理（緑）でブランドカラーを明確に分けたUXを設計。VitalController を新設し、体重（小数点第一位）、血圧、血糖値をワンアクションで一括保存（Mass Assignment）するロジックを構築。

3. 【新規】名前空間とディレクトリ構造の不整合の解決
課題: コントローラーのコード作成時に namespace App\Controller; と記述したため、Laravelのローダークラスが正常に認識せず、クラスの重複定義エラー（Cannot redeclare class...）を引き起こした。

解決: ディレクトリ配置ルールに則り namespace App\Http\Controllers; へ正確に補正。オートロードの仕組みとPSR-4規格への理解を深める契機とした。

4. 【新規】開発フェーズに合わせた疎結合設計（仮ユーザーIDの実装）
課題: 認証機能（ログイン）を組み込む前段階で、リレーショナルデータである user_id（外部キー制約・NOT NULL）の保存時に、セッション未確立によるデータベースクエリエラー（Integrity constraint violation）が発生。

解決: 開発のボトルネックを排除するため、認証制限（auth ミドルウェア）を意図的に外した独立ルートを再設計。コントローラー側で仮のシステムユーザーID（1）を強制補完する防衛コードを挟むことで、認証機能の完成を待たずに「バイタル・病院管理のモジュール開発」を並行して推進できるアプローチをとった。

5. 医療・健康データにおけるバリデーションの徹底
課題: 不正なリクエストや、健康データとしてあり得ない異常値（例: 体重500kgなど）の混入によるシステム信頼性の低下。

解決: サーバーサイド（Laravel）で厳格な between 構文を用いた数値範囲バリデーションを実装。データの堅牢性を大幅に向上。

6. Eager Loadingによるパフォーマンス最適化
課題: 医療データ特有の多階層リレーションによるN+1問題の発生。

解決: コントローラー側で with(['department.hospital', 'medicines.takingLogs']) や、個別リクエスト時の $hospital->load('departments') を用いた先行読み込みを徹底し、クエリ発行回数を最小限に抑制。

🔧 環境構築
Bash
git clone [repository-url]
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail composer require doctrine/dbal
./vendor/bin/sail artisan migrate --seed