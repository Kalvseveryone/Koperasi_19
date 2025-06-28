# Panduan Autentikasi Mobile App Ionic

## Masalah yang Sudah Diperbaiki

### 1. **Duplikasi Middleware**
- ✅ Menghapus duplikasi middleware 'role' di `Kernel.php`
- ✅ Membersihkan konfigurasi API middleware group

### 2. **Konfigurasi Sanctum**
- ✅ Menambahkan domain mobile (`capacitor://localhost`, `ionic://localhost`)
- ✅ Mengatur guard API yang proper
- ✅ Menambahkan abilities pada token

### 3. **Error Handling**
- ✅ Menambahkan try-catch di MobileAuthController
- ✅ Response format yang konsisten dengan `success` field
- ✅ Logging untuk debugging

### 4. **CORS Configuration**
- ✅ Menambahkan header yang diperlukan
- ✅ Domain mobile yang komprehensif
- ✅ Support credentials untuk mobile

## Endpoint API yang Tersedia

### Login
```
POST /api/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

**Response Success:**
```json
{
    "success": true,
    "message": "Login berhasil",
    "role": "admin|kolektor|anggota",
    "user": {...},
    "token": "1|abc123..."
}
```

### Logout
```
POST /api/auth/logout
Authorization: Bearer {token}
```

### Get User Info
```
GET /api/auth/user
Authorization: Bearer {token}
```

## Implementasi di Ionic

### 1. **Service Authentication**

```typescript
// auth.service.ts
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';
import { tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private apiUrl = 'http://your-domain.com/api';
  private tokenKey = 'auth_token';
  private userKey = 'user_data';
  
  private isAuthenticatedSubject = new BehaviorSubject<boolean>(false);
  public isAuthenticated$ = this.isAuthenticatedSubject.asObservable();

  constructor(private http: HttpClient) {
    this.checkAuthStatus();
  }

  login(email: string, password: string): Observable<any> {
    return this.http.post(`${this.apiUrl}/auth/login`, {
      email,
      password
    }).pipe(
      tap(response => {
        if (response.success) {
          this.setToken(response.token);
          this.setUser(response.user);
          this.isAuthenticatedSubject.next(true);
        }
      })
    );
  }

  logout(): Observable<any> {
    const token = this.getToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    return this.http.post(`${this.apiUrl}/auth/logout`, {}, { headers }).pipe(
      tap(() => {
        this.clearAuth();
        this.isAuthenticatedSubject.next(false);
      })
    );
  }

  getUser(): Observable<any> {
    const token = this.getToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    return this.http.get(`${this.apiUrl}/auth/user`, { headers });
  }

  // Token management
  private setToken(token: string): void {
    localStorage.setItem(this.tokenKey, token);
  }

  private getToken(): string {
    return localStorage.getItem(this.tokenKey) || '';
  }

  private setUser(user: any): void {
    localStorage.setItem(this.userKey, JSON.stringify(user));
  }

  private getUserData(): any {
    const userData = localStorage.getItem(this.userKey);
    return userData ? JSON.parse(userData) : null;
  }

  private clearAuth(): void {
    localStorage.removeItem(this.tokenKey);
    localStorage.removeItem(this.userKey);
  }

  private checkAuthStatus(): void {
    const token = this.getToken();
    const user = this.getUserData();
    this.isAuthenticatedSubject.next(!!(token && user));
  }

  isLoggedIn(): boolean {
    return this.isAuthenticatedSubject.value;
  }
}
```

### 2. **HTTP Interceptor untuk Token Management**

```typescript
// auth.interceptor.ts
import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { AuthService } from './auth.service';
import { Router } from '@angular/router';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {
  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const token = localStorage.getItem('auth_token');
    
    if (token) {
      request = request.clone({
        setHeaders: {
          Authorization: `Bearer ${token}`
        }
      });
    }

    return next.handle(request).pipe(
      catchError((error: HttpErrorResponse) => {
        if (error.status === 401) {
          // Token expired or invalid, redirect to login
          this.authService.logout().subscribe(() => {
            this.router.navigate(['/login']);
          });
        }
        return throwError(() => error);
      })
    );
  }
}
```

### 3. **Login Component**

```typescript
// login.page.ts
import { Component } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';
import { LoadingController, AlertController } from '@ionic/angular';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html'
})
export class LoginPage {
  email: string = '';
  password: string = '';

  constructor(
    private authService: AuthService,
    private router: Router,
    private loadingController: LoadingController,
    private alertController: AlertController
  ) {}

  async login() {
    if (!this.email || !this.password) {
      this.showAlert('Error', 'Email dan password harus diisi');
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Logging in...'
    });
    await loading.present();

    this.authService.login(this.email, this.password).subscribe({
      next: (response) => {
        loading.dismiss();
        if (response.success) {
          // Redirect based on role
          switch (response.role) {
            case 'admin':
              this.router.navigate(['/admin']);
              break;
            case 'kolektor':
              this.router.navigate(['/kolektor']);
              break;
            case 'anggota':
              this.router.navigate(['/anggota']);
              break;
            default:
              this.router.navigate(['/home']);
          }
        } else {
          this.showAlert('Error', response.message || 'Login gagal');
        }
      },
      error: (error) => {
        loading.dismiss();
        console.error('Login error:', error);
        this.showAlert('Error', 'Terjadi kesalahan saat login. Silakan coba lagi.');
      }
    });
  }

  async showAlert(header: string, message: string) {
    const alert = await this.alertController.create({
      header,
      message,
      buttons: ['OK']
    });
    await alert.present();
  }
}
```

### 4. **App Module Configuration**

```typescript
// app.module.ts
import { NgModule } from '@angular/core';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { AuthInterceptor } from './interceptors/auth.interceptor';

@NgModule({
  // ... other configurations
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi: true
    }
  ]
})
export class AppModule { }
```

## Troubleshooting

### 1. **Error "cannot get token"**
- ✅ Pastikan endpoint `/api/auth/login` dapat diakses
- ✅ Periksa format request (email dan password)
- ✅ Pastikan user ada di database
- ✅ Periksa log Laravel untuk error detail

### 2. **Error "sesi anda telah berakhir"**
- ✅ Token expired - user harus login ulang
- ✅ Token tidak valid - logout dan login ulang
- ✅ Periksa Authorization header format

### 3. **CORS Error**
- ✅ Pastikan domain Ionic ada di `config/cors.php`
- ✅ Periksa `supports_credentials` setting
- ✅ Pastikan server Laravel berjalan

### 4. **Network Error**
- ✅ Periksa URL API di Ionic
- ✅ Pastikan server Laravel dapat diakses dari mobile
- ✅ Periksa firewall/network settings

## Testing

### 1. **Test dengan Postman**
```
POST http://your-domain.com/api/auth/login
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password"
}
```

### 2. **Test Token**
```
GET http://your-domain.com/api/auth/user
Authorization: Bearer {token}
```

## Log Laravel

Untuk debugging, periksa log Laravel di:
```
storage/logs/laravel.log
```

Error mobile akan tercatat dengan prefix "Mobile login error:", "Mobile logout error:", dll.

## Catatan Penting

- **Tidak ada refresh token** - Jika token expired, user harus login ulang
- **Token management sederhana** - Token disimpan di localStorage
- **Auto logout** - Jika mendapat response 401, user otomatis diarahkan ke login 