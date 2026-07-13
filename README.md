# 🏥 MediSync (Health-Log App)
> 複数医療機関の処方を一括管理する、患者主体の服薬アドヒアランス向上プラットフォーム

[![Laravel](https://img.shields.io/badge/Laravel-13.4-FF2D20?logo=laravel&style=flat-square)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?logo=php&style=flat-square)](https://www.php.net/)
[![Docker](https://img.shields.io/badge/Infrastructure-Docker_Sail-2496ED?logo=docker&style=flat-square)](https://www.docker.com/)

## 📋 プロジェクト概要
複数の病院・診療科を跨いで処方される薬剤情報を一元管理し、「飲み忘れ」や「情報の分断」を防ぐためのWebアプリケーションです。
さらに、患者のQOL向上を目的とし、服薬管理だけでなく「体重・血圧・血糖値」を一括して記録・管理できるバイタルログ機能とのクロスアプリケーション連携を備えています。

## 🛠 技術スタック
- **Backend**: PHP 8.5 / Laravel 13.4 (PSR-12準拠、型宣言の徹底)
- **Frontend**: Tailwind CSS / Vite 5.x / Blade Templates
- **Database**: MySQL 8.0 (HeidiSQL for GUI)
- **Infrastructure**: Docker (Laravel Sail) / Ubuntu (WSL2)
- **Tooling**: Doctrine DBAL (DBスキーマ変更用)

## 🏗 システム設計 (System Architecture)

### 1. データ構造（ドリルダウン設計）
医療情報・体調記録の整合性を担保するため、以下のリレーションを採用しています。
- **Hospitals** (病院) └── **Departments** (診療科) └── **Prescriptions** (処方箋) └── **Medicines** (薬剤) └── **TakingLogs** (服用履歴：秒単位記録)
- **Vitals** (バイタルログ：体重、最高/最低血圧、血糖値の一括管理テーブル)

### 2. コンポーネント指向を意識した2カラムUI
日常のメイン行動である「服用・確認（タイムライン）」と、管理機能である「マスタ登録・変更・削除（CRUD）」の導線を分離。認知負荷を最小限に抑えるプロ仕様の2カラムレイアウトを採用。

## 🚀 開発ログ & 技術的課題へのアプローチ

### 1. 医療データの正確性担保（時分秒のデータ消失バグの解決）
- **課題**: 保存された服用履歴（TakingLogs）の時刻がすべて `00:00` に丸められてしまい、正確な服薬時間が記録できない。
- **解決**: 原因がデータベースの `DATE` 型にあると特定。`doctrine/dbal` パッケージを導入し、既存データを保護しつつカラム型を `DATETIME`（日時）型へ安全に変更するマイグレーションを計画・実行。これにより「秒単位の正確性」を担保した。

### 2. コードベース of クリーンアップと責務の明確化（リファクタリング）
- **課題**: 急な方針変更（バイタル一括保存機能の追加等）に伴い、旧ロジック用のコントローラーや不要なビューが混在し、コードの可読性と保守性が低下。
- **解決**: `HealthLogController` を廃止し新設の `VitalController` に一本化。また不要なモデルやビューを完全に断捨離。`MedicineController` はガード節（Early Return）による早期離脱とEager Loadingの徹底により、モダンかつ低結合なコードへとリファクタリングを実施。

### 3. 多対多・1対多の階層構造（親子関係）CRUDの実装
- **課題**: 病院（Hospital）と受診科（Department）の親子リレーションデータを、画面遷移の認知負荷を下げつつ、リレーショナルデータを破綻させずに登録・表示させる必要性。
- **解決**: 病院詳細画面（`hospitals.show`）内に受診科のインライン追加フォームを統合。`HospitalController@show` では `load('departments')` を用いて受診科データを一括遅延読み込み（Lazy Eager Loading）し、N+1問題を回避しつつシームレスなUXを実現。

### 4. コンテナ環境におけるフロントエンドビルド環境（Vite）の最適化
- **課題**: 開発中のTailwind CSS適用やホットリロード（HMR）のためBladeに `@vite` 構文を導入した際、コンテナ環境内にフロントエンド資産やマニフェストファイル（`manifest.json`）が存在せず、500エラー（`ViteManifestNotFoundException`）が発生。
- **解決**: Docker（Laravel Sail）コンテナ内で `npm install` を実行してNode.js環境を整備し、`npm run dev` 開発サーバーを常時起動。フロントエンドとバックエンドのビルドエコシステムをコンテナ内で完結させ、本番ビルド（`npm run build`）へのデプロイパイプラインの基礎を構築。

### 5. 階層型Eager Loadingのバグ検知とデータスキーマの整合性担保【NEW】
- **課題**: 受診科詳細画面（`departments.show`）への遷移時、`RelationNotFoundException` が発生。コントローラー側でリレーショナルデータの先行読み込み（`$department->load(['hospital', 'prescriptions'])`）を試みた際、`Department` モデルに `prescriptions`（1対多）のメソッド定義が不足している設計の乖離を検知。また、コントローラーが期待する送信値とDBの物理カラム（`prescribed_date` / `next_visit_date` / `doctor_name`）との間に命名のズレが存在していた。
- **解決**: 
  1. `Department` モデルに `HasMany` リレーション（型宣言 `: HasMany` の徹底）を追加し、`Prescription` モデル側にも対応する `BelongsTo` 逆リレーションを完全実装。
  2. フロントエンドの入力フォーム（`name` 属性）、コントローラーのバリデーションルール、およびデータベーススキーマを新設計へ一元統一。
  3. サーバー側（Laravel）で `before_or_equal:today`（未来日での処方発行の禁止）および `after_or_equal:prescribed_date`（処方日より前の次回受診日の禁止）という業務ロジックに即した堅牢な相関バリデーションを導入。フロントエンド（HTMLの `max` 属性）との二重防御体制を構築。
  4. 整合性を維持するため `php artisan migrate:fresh --seed` を実行し、HeidiSQLを介してDB全体のクリーンな再構築とデータ投入テストを完了。

## 🔧 環境構築
```bash
git clone [repository-url]
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail composer require doctrine/dbal
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev  # 開発サーバー起動
./vendor/bin/sail artisan migrate:fresh --seed