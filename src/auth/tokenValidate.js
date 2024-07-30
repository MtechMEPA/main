// auth/tokenValidate.js

export function decodeToken() {
    const token = localStorage.getItem('token'); // Ambil token dari localStorage
    if (!token) {
      throw new Error('Token not found');
    }
  
    const tokenString = String(token); // Convert token to string
    let payload = "";
    if (tokenString) {
      payload = JSON.parse(atob(tokenString.split('.')[1])); // Decode payload
    }
  
    return payload;
  }
  
  export function isTokenExpired() {
    let payload;
    try {
      payload = decodeToken();
    } catch (error) {
      console.error(error);
      return true; // Consider token expired if it cannot be decoded
    }
  
    const exp = payload.exp * 1000; // Convert to milliseconds
  
    return Date.now() >= exp;
  }
  